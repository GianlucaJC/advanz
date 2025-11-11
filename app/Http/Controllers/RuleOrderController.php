<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Assicurati che questa riga sia presente
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RuleOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()) {
                $id_user = Auth::user()->id;
                $info = User::select("is_admin")->where('id', '=', $id_user)->first();
                $is_admin = $info ? $info->is_admin : 0;
                if ($is_admin == 0) return response()->view('all_views.viewmaster.error', compact('id_user'));
            }
            return $next($request);
        });
    }

    private function getCountries()
    {
        return [
            '2' => "France",
            '3' => "Austria",
            '4' => "Denmark",
            '5' => "Germany",
            '6' => "Ireland",
            '7' => "Spain",
            '8' => "United Kingdom",
        ];
    }

    public function manage()
    {
        $countries = $this->getCountries();

        $allestimenti = DB::table('allestimento as a')
            ->join('molecola as m', 'a.id_molecola', '=', 'm.id')
            ->join('packaging as p', 'a.id_pack', '=', 'p.id')
            ->leftJoin('pack_qty as pq', 'a.id_pack_qty', '=', 'pq.id') // Changed to leftJoin
            ->where('a.dele', 0)
            // ->where('a.id_pack_qty', '!=', 0) // Rimosso per mostrare tutti gli allestimenti non cancellati, inclusi quelli con id_pack_qty = 0
            ->select(
                'a.id',
                DB::raw("CONCAT(m.descrizione, ' - ', p.descrizione, ' - ', COALESCE(pq.descrizione, 'N/A')) as descrizione_completa") // Handle NULL for pq.descrizione
            )
            ->orderBy('m.descrizione')
            ->orderBy('p.descrizione')
            ->orderBy('pq.descrizione')
            ->get();

        $rules = DB::table('rule_order')
            ->where('can_order', 1)
            ->get()
            ->groupBy('id_country')
            ->map(function ($items) {
                return $items->pluck('id_allestimento')->toArray();
            });

        return view('all_views.manage_rules', compact('countries', 'allestimenti', 'rules'));
    }

    public function update(Request $request)
    {
    
        $request->validate([
            'rules' => 'nullable|array',
            'rules.*' => 'nullable|array', // Allow empty/null values for countries with no selections
            'rules.*.*' => 'integer|exists:allestimento,id'
        ]);

        Log::info('RuleOrderController@update: Inizio processo di aggiornamento regole.');
        $allKnownCountries = $this->getCountries(); // Ottieni tutti i paesi che il sistema conosce
        $submittedRules = $request->input('rules', []); // Ottieni solo le regole inviate dal form
        Log::info('RuleOrderController@update: Regole sottomesse dal form:', $submittedRules);

        DB::beginTransaction();

        try {
            // 1. Get all active `allestimento` IDs
            $allestimentoIds = DB::table('allestimento')->where('dele', 0)->pluck('id')->all();
            Log::info('RuleOrderController@update: Found ' . count($allestimentoIds) . ' active allestimento items.');

            // 2. Delete all existing rules to rebuild them from scratch
            DB::table('rule_order')->delete();
            Log::info('RuleOrderController@update: All existing rules have been deleted.');

            $insertData = [];
            $now = now();

            // 3. Iterate over all known countries and all active allestimenti to build the full set of rules
            foreach ($allKnownCountries as $countryId => $countryName) {
                // Get the submitted orderable items for the current country.
                // The `array_filter` removes any empty values that might come from the form.
                $orderableIdsForCountry = isset($submittedRules[$countryId]) ? array_filter($submittedRules[$countryId]) : [];

                foreach ($allestimentoIds as $allestimentoId) {
                    $insertData[] = [
                        'id_country' => $countryId,
                        'id_allestimento' => $allestimentoId,
                        'can_order' => in_array($allestimentoId, $orderableIdsForCountry) ? 1 : 0,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            // 4. Insert all the new rules in a single operation.
            DB::table('rule_order')->insert($insertData);
            Log::info('RuleOrderController@update: Inserted ' . count($insertData) . ' new rules.');

            DB::commit();
            Log::info('RuleOrderController@update: Transazione completata con successo.');

            return redirect()->route('rules.manage')->with('success', 'Regole di ordinabilità aggiornate con successo!');

        } catch (\Exception $e) {
            Log::error('RuleOrderController@update: Errore durante l\'aggiornamento delle regole: ' . $e->getMessage(), ['exception' => $e]);
            DB::rollBack();
            return redirect()->route('rules.manage')->with('error', 'Si è verificato un errore durante l\'aggiornamento delle regole.');
        }
    }
}