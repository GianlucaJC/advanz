<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
    /**
     * Mostra la pagina di gestione degli utenti.
     */
    public function manageUsers()
    {
        // Carica tutti gli utenti eccetto l'admin stesso, se si vuole escluderlo
        $users = User::orderBy('last_name')->orderBy('first_name')->get();
        
        return view('all_views.manage_users', compact('users'));
    }

    /**
     * Aggiorna i dati anagrafici di un utente.
     */
    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'istituto' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'shipping_address1' => 'required|string|max:255',
            'shipping_address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'email_ref' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()], 422);
        }

        $user = User::find($request->id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Utente non trovato.'], 404);
        }

        $user->update($request->except(['_token', 'id']));

        return response()->json(['success' => true, 'message' => 'Utente aggiornato con successo.']);
    }

    /**
     * Aggiorna il ruolo di un utente (is_user vs is_pharma).
     */
    public function updateUserRole(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'role' => 'required|string|in:is_user,is_pharma',
            'active' => 'required|boolean',
        ]);

        $user = User::find($request->id);

        if ($user->is_admin) {
            return response()->json(['success' => false, 'message' => 'Il ruolo di un amministratore non può essere modificato.'], 403);
        }

        $roleField = $request->role;
        $user->$roleField = $request->active ? 1 : 0;

        // Assicura che un utente non sia sia user che pharma
        if ($request->active) {
            $otherRole = ($roleField === 'is_user') ? 'is_pharma' : 'is_user';
            $user->$otherRole = 0;
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'Ruolo utente aggiornato.']);
    }
}