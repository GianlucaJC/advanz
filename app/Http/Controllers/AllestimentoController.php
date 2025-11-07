<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Molecola;
use App\Models\Packaging;
use App\Models\PackQty;
use App\Models\Allestimento;

class AllestimentoController extends Controller
{
    /**
     * Mostra la vista principale per la gestione dell'allestimento.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $molecole = Molecola::orderBy('descrizione')->get();
        return view('all_views.manage_allestimento', compact('molecole'));
    }

    /**
     * Recupera le opzioni di Packaging disponibili per una data Molecola.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPackaging(Request $request)
    {
        $request->validate([
            'molecola_id' => 'required|exists:molecola,id',
        ]);

        // Trova le voci di allestimento per la molecola data
        // Poi ottieni gli ID di packaging unici da quelle voci di allestimento
        // E infine recupera i dettagli del Packaging
        $packagingIds = Allestimento::where('id_molecola', $request->molecola_id)
                                    ->distinct('id_pack')
                                    ->pluck('id_pack');

        $packaging = Packaging::whereIn('id', $packagingIds)
                                ->where('active', 1) // Assumendo un campo 'active' per il packaging
                                ->orderBy('descrizione')
                                ->get(['id', 'descrizione']);

        return response()->json($packaging);
    }

    /**
     * Recupera le opzioni di PackQty disponibili per un dato Packaging.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPackQty(Request $request)
    {
        $request->validate([
            'pack_id' => 'required|exists:packaging,id',
        ]);

        // Trova le voci di allestimento per il packaging dato
        // Poi ottieni gli ID di pack_qty unici da quelle voci di allestimento
        // E infine recupera i dettagli del PackQty
        $packQtyIds = Allestimento::where('id_pack', $request->pack_id)
                                  ->distinct('id_pack_qty')
                                  ->pluck('id_pack_qty');

        $packQty = PackQty::whereIn('id', $packQtyIds)
                            ->orderBy('descrizione')
                            ->get(['id', 'descrizione']);

        return response()->json($packQty);
    }

    /**
     * Recupera i dati di Allestimento basati sulle selezioni di Molecola, Packaging e PackQty.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllestimentoData(Request $request)
    {
        $request->validate([
            'molecola_id' => 'required|exists:molecola,id',
            'pack_id' => 'required|exists:packaging,id',
            'pack_qty_id' => 'required|exists:pack_qty,id',
        ]);

        $allestimento = Allestimento::where('id_molecola', $request->molecola_id)
                                    ->where('id_pack', $request->pack_id)
                                    ->where('id_pack_qty', $request->pack_qty_id)
                                    ->get();

        return response()->json($allestimento);
    }

    public function refillAllestimento(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:allestimento,id',
            'refill_qty' => 'required|integer|min:1',
        ]);

        $allestimento = Allestimento::find($request->id);
        $allestimento->stock += $request->refill_qty;
        $allestimento->remaining += $request->refill_qty;
        $allestimento->save();

        return response()->json([
            'success' => true, 
            'new_stock' => $allestimento->stock,
            'new_remaining' => $allestimento->remaining
        ]);
    }

    public function saveAllestimento(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:allestimento,id',
            'cod_liof' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $allestimento = Allestimento::find($request->id);
        $allestimento->cod_liof = $request->cod_liof;
        $allestimento->descrizione = $request->description;
        $allestimento->save();

        return response()->json(['success' => true]);
    }
}