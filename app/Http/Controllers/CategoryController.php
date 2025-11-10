<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Molecola;
use App\Models\Packaging;
use App\Models\PackQty;
use App\Models\Allestimento;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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

    public function manage()
    {
        $molecole = Molecola::orderBy('descrizione')->get();
        $allPackaging = Packaging::where('active', 1)->orderBy('descrizione')->get();
        $allPackQty = PackQty::orderBy('descrizione')->get();

        return view('all_views.manage_categories', compact('molecole', 'allPackaging', 'allPackQty'));
    }

    public function getPackagingForMolecule(Request $request)
    {
        $request->validate(['molecola_id' => 'required|exists:molecola,id']);

        // Packaging già associati alla molecola
        $associatedPackagingIds = Allestimento::where('id_molecola', $request->molecola_id)
            ->where('dele', 0)
            ->distinct()
            ->pluck('id_pack');

        $associatedPackaging = Packaging::whereIn('id', $associatedPackagingIds)
            ->where('active', 1)
            ->orderBy('descrizione')->get();

        // Packaging disponibili: quelli non ancora associati E quelli che sono associati ma con dele=1
        // 1. Prendo tutti i packaging attivi
        $allActivePackagingIds = Packaging::where('active', 1)->pluck('id');
        // 2. Prendo tutti i packaging (anche dele=1) per la molecola
        $allMoleculePackagingIds = Allestimento::where('id_molecola', $request->molecola_id)->distinct()->pluck('id_pack');
        // 3. Gli ID disponibili sono quelli attivi che NON sono tra gli associati (dele=0)
        $availablePackagingIds = $allActivePackagingIds->diff($associatedPackagingIds);
        // 4. Recupero i modelli
        $availablePackaging = Packaging::whereIn('id', $availablePackagingIds)->orderBy('descrizione')->get();

        return response()->json(['associated' => $associatedPackaging, 'available' => $availablePackaging]);
    }

    public function getPackQtyForPackaging(Request $request)
    {
        $request->validate([
            'molecola_id' => 'required|exists:molecola,id',
            'pack_id' => 'required|exists:packaging,id'
        ]);

        $associatedPackQtyIds = Allestimento::where('id_molecola', $request->molecola_id)
            ->where('dele', 0)
            ->where('id_pack', $request->pack_id)
            ->distinct()
            ->pluck('id_pack_qty');

        // Escludiamo il record segnaposto (ID 0) se presente
        $associatedPackQtyIds = $associatedPackQtyIds->filter(fn($id) => $id > 0);

        $associatedPackQty = PackQty::whereIn('id', $associatedPackQtyIds)->orderBy('descrizione')->get();

        // Le quantità disponibili sono tutte quelle che NON sono già associate attivamente
        $availablePackQty = PackQty::whereNotIn('id', $associatedPackQtyIds)
            ->orderBy('descrizione')
            ->get();
        
        return response()->json(['associated' => $associatedPackQty, 'available' => $availablePackQty]);
    }

    public function associatePackaging(Request $request)
    {
        $request->validate([
            'molecola_id' => 'required|exists:molecola,id',
            'pack_id' => 'required|exists:packaging,id',
        ]);

        // Per associare un packaging, dobbiamo creare almeno un record in allestimento.
        // Dato che non abbiamo ancora una quantità, creiamo un record "segnaposto" con id_pack_qty a 0 o null.
        // Questo record non sarà utilizzabile per gli ordini ma stabilisce il legame.
        // NOTA: Assicurati che la colonna `id_pack_qty` possa accettare NULL o 0.
        // Se non può, questa logica va rivista (es. creando una tabella pivot separata solo per molecola-packaging).
        // Assumiamo che 0 sia un valore accettabile e non usato per quantità reali.
        // Usiamo updateOrCreate per riattivare un record con dele=1 se esiste.
        Allestimento::updateOrCreate(
            [
                'id_molecola' => $request->molecola_id,
                'id_pack' => $request->pack_id,
                'id_pack_qty' => 0 // Usiamo 0 come segnaposto per l'associazione packaging-molecola
            ], ['dele' => 0]
        );

        return response()->json(['success' => true, 'message' => 'Packaging associato con successo.']);
    }

    // public function dissociatePackaging(Request $request)
    // {
    //     // Funzionalità rimossa su richiesta. L'associazione Packaging-Molecola è permanente.
    //     // La cancellazione soft è gestita solo a livello di PackQty.
    //     $request->validate([
    //         'molecola_id' => 'required|exists:molecola,id',
    //         'pack_id' => 'required|exists:packaging,id',
    //     ]);

    //     // Rimuove tutte le associazioni (incluse tutte le quantità) per questa molecola e packaging
    //     Allestimento::where('id_molecola', $request->molecola_id)
    //         ->where('id_pack', $request->pack_id)
    //         ->update(['dele' => 1]);

    //     return response()->json(['success' => true, 'message' => 'Packaging disassociato con successo.']);
    // }

    public function associatePackQty(Request $request)
    {
        $request->validate([
            'molecola_id' => 'required|exists:molecola,id',
            'pack_id' => 'required|exists:packaging,id',
            'pack_qty_id' => 'required|exists:pack_qty,id',
        ]);

        // 1. Assicura che il record per la quantità specifica sia attivo.
        // `updateOrCreate` cerca un record con la combinazione di chiavi specificata.
        // Se lo trova (anche se ha dele=1), lo aggiorna impostando dele=0.
        // Se non lo trova, lo crea con dele=0. Questo previene la creazione di duplicati.
        Allestimento::updateOrCreate(
            [
                'id_molecola' => $request->molecola_id,
                'id_pack' => $request->pack_id,
                'id_pack_qty' => $request->pack_qty_id,
            ],
            ['dele' => 0]
        );

        // 2. Assicura che anche il record "segnaposto" (id_pack_qty=0) sia attivo.
        // Questo record serve a mantenere l'associazione tra Molecola e Packaging
        // anche se non ci sono quantità specifiche, permettendo al packaging di essere
        // visualizzato correttamente nella lista di sinistra.
        Allestimento::updateOrCreate(
            [
                'id_molecola' => $request->molecola_id,
                'id_pack' => $request->pack_id,
                'id_pack_qty' => 0,
            ],
            ['dele' => 0]
        );

        return response()->json(['success' => true, 'message' => 'Quantità associata con successo.']);
    }

    public function dissociatePackQty(Request $request)
    {
        $request->validate([
            'id_molecola' => $request->molecola_id,
            'id_pack' => $request->pack_id,
            'id_pack_qty' => $request->pack_qty_id,
        ]);

        // Disattiva (soft delete) il record della quantità specifica.
        Allestimento::where('id_molecola', $request->molecola_id)
            ->where('id_pack', $request->pack_id)
            ->where('id_pack_qty', $request->pack_qty_id) // Target the specific quantity
            ->update(['dele' => 1]);

        // Controlla se sono rimaste altre quantità ATTIVE per questo packaging.
        // Se non ce ne sono più, disattiviamo anche il record segnaposto per far
        // scomparire il packaging dalla lista degli associati.
        $hasActiveQuantities = Allestimento::where('id_molecola', $request->molecola_id)
                                ->where('id_pack', $request->pack_id)
                                ->where('dele', 0)
                                ->where('id_pack_qty', '!=', 0) // Escludiamo il segnaposto stesso dal conteggio
                                ->exists();

        if (!$hasActiveQuantities) {
            // Non ci sono più quantità attive, quindi disattiviamo anche il segnaposto.
            Allestimento::where('id_molecola', $request->molecola_id)
                ->where('id_pack', $request->pack_id)
                ->where('id_pack_qty', 0)
                ->update(['dele' => 1]);
        }

        return response()->json(['success' => true, 'message' => 'Quantità disassociata con successo.']);
    }

    public function storePackaging(Request $request)
    {
        $request->validate([
            'descrizione' => 'required|string|max:255|unique:packaging,descrizione',
        ]);

        $packaging = Packaging::create([
            'descrizione' => $request->descrizione,
            'active' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Nuovo packaging creato con successo.', 'packaging' => $packaging]);
    }

    public function storePackQty(Request $request)
    {
        $request->validate([
            'descrizione' => 'required|string|max:255|unique:pack_qty,descrizione',
        ]);

        $packQty = PackQty::create([
            'descrizione' => $request->descrizione,
            // Assumendo che non ci siano altri campi obbligatori
        ]);

        return response()->json(['success' => true, 'message' => 'Nuova quantità creata con successo.', 'packQty' => $packQty]);
    }

    public function updateMoleculeInfo(Request $request)
    {
        $request->validate([
            'molecola_id' => 'required|exists:molecola,id',
            'info' => 'nullable|string',
        ]);

        $molecola = Molecola::find($request->molecola_id);

        if (!$molecola) {
            return response()->json(['success' => false, 'message' => 'Molecola non trovata.'], 404);
        }

        $molecola->info = $request->info;
        $molecola->save();

        return response()->json(['success' => true, 'message' => 'Informazioni sulla molecola aggiornate con successo.']);
    }
}