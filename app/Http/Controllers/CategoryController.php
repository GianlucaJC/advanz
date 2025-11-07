<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Molecola;
use App\Models\Packaging;
use App\Models\PackQty;
use App\Models\Allestimento;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
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
            ->distinct()
            ->pluck('id_pack');

        $associatedPackaging = Packaging::whereIn('id', $associatedPackagingIds)->orderBy('descrizione')->get();
        

        // Packaging non ancora associati, per il dropdown di aggiunta
        $availablePackaging = Packaging::where('active', 1)->whereNotIn('id', $associatedPackagingIds)->orderBy('descrizione')->get();

        return response()->json(['associated' => $associatedPackaging, 'available' => $availablePackaging]);
    }

    public function getPackQtyForPackaging(Request $request)
    {
        $request->validate([
            'molecola_id' => 'required|exists:molecola,id',
            'pack_id' => 'required|exists:packaging,id'
        ]);

        $associatedPackQtyIds = Allestimento::where('id_molecola', $request->molecola_id)
            ->where('id_pack', $request->pack_id)
            ->distinct()
            ->pluck('id_pack_qty');
        

        $associatedPackQty = PackQty::whereIn('id', $associatedPackQtyIds)->orderBy('descrizione')->get();
        $availablePackQty = PackQty::whereNotIn('id', $associatedPackQtyIds)->orderBy('descrizione')->get();

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
        
        Allestimento::firstOrCreate(
            [
                'id_molecola' => $request->molecola_id,
                'id_pack' => $request->pack_id,
                'id_pack_qty' => 0 // Usiamo 0 come segnaposto per l'associazione packaging-molecola
            ]
        );

        return response()->json(['success' => true, 'message' => 'Packaging associato con successo.']);
    }

    public function dissociatePackaging(Request $request)
    {
        $request->validate([
            'molecola_id' => 'required|exists:molecola,id',
            'pack_id' => 'required|exists:packaging,id',
        ]);

        // Rimuove tutte le associazioni (incluse tutte le quantità) per questa molecola e packaging
        Allestimento::where('id_molecola', $request->molecola_id)
            ->where('id_pack', $request->pack_id)
            ->delete();

        return response()->json(['success' => true, 'message' => 'Packaging disassociato con successo.']);
    }

    public function associatePackQty(Request $request)
    {
        $request->validate([
            'molecola_id' => 'required|exists:molecola,id',
            'pack_id' => 'required|exists:packaging,id',
            'pack_qty_id' => 'required|exists:pack_qty,id',
        ]);

        // Crea il record di allestimento specifico
        Allestimento::firstOrCreate([
            'id_molecola' => $request->molecola_id,
            'id_pack' => $request->pack_id,
            'id_pack_qty' => $request->pack_qty_id,
        ]);

        // Potrebbe esserci un record segnaposto (con id_pack_qty=0), lo rimuoviamo se esiste.
        $this->dissociatePackQtyPlaceholder($request->molecola_id, $request->pack_id); // This now does a hard delete

        return response()->json(['success' => true, 'message' => 'Quantità associata con successo.']);
    }

    public function dissociatePackQty(Request $request)
    {
        $request->validate([
            'molecola_id' => 'required|exists:molecola,id',
            'pack_id' => 'required|exists:packaging,id',
            'pack_qty_id' => 'required|exists:pack_qty,id',
        ]);

        Allestimento::where('id_molecola', $request->molecola_id)
            ->where('id_pack', $request->pack_id)
            ->where('id_pack_qty', $request->pack_qty_id) // Target the specific quantity
            ->delete();

        // Se non ci sono più quantità associate a questo packaging per questa molecola,
        // potremmo voler reinserire il record segnaposto per mantenere l'associazione packaging-molecola.
        $remaining = Allestimento::where('id_molecola', $request->molecola_id)
                                ->where('id_pack', $request->pack_id)
                                ->where('id_pack_qty', '!=', 0)
                                ->count();

        if ($remaining === 0) {
            // Riattiva o crea il segnaposto
            $this->associatePackaging($request);
        }

        return response()->json(['success' => true, 'message' => 'Quantità disassociata con successo.']);
    }

    private function dissociatePackQtyPlaceholder($molecola_id, $pack_id)
    {
        Allestimento::where('id_molecola', $molecola_id)
            ->where('id_pack', $pack_id)
            ->where('id_pack_qty', 0)
            ->delete();
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
}