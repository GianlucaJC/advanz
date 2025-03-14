<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\uploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

//estendo AjaxController perchè potrebbero servirmi metodi e proprietà di quella classe
class FileUploadController extends AjaxController

{
    public function upload(Request $request)
    {
        //per ereditare metodi della classe
        //parent::__construct();
        //$molecola=$this->molecola;
        
        $id_user = Auth::user()->id;
        $id_molecola=$request->input('id_molecola');
        $id_pack=$request->input('id_pack');
        $testo_ref=$request->input('testo_ref');

        // Validate the uploaded file
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);
        // Check if the file is valid
        if ($request->file('file')->isValid()) {
            // Store the file in the 'uploads' directory on the 'public' disk
            $filePath = $request->file('file')->store('uploads', 'public');
            $info=explode("/",$filePath);
            $filereal=$info[1];
            $uploads=new uploads;
            $uploads->id_user=$id_user;
            $uploads->id_molecola=$id_molecola;
            $uploads->id_pack=$id_pack;
            $uploads->filereal=$filereal;
            $uploads->testo_ref=$testo_ref;
            $uploads->save();            
            // Return success response
            return back()->with('success', 'File uploaded successfully')->with('file', $filePath);
        }
        
        // Return error response
        return back()->with('error', 'File upload failed');
    }
}
?>