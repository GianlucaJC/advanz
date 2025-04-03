<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\uploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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
        $culture_date=$request->input('culture_date');
        $species_name=$request->input('species_name');
        $infection_source=$request->input('infection_source');
        $test_method=$request->input('test_method');
        $test_result=$request->input('test_result');


        // Validate the uploaded file
        /*
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);
        */
        if ($request->has('wf')) {
            $validatedData = Validator::make($request->all(), [
                'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:2048',
            ]);
            if ($validatedData->fails()) {
                return back()->with('error', 'Failed');
            }
        }

        // Check if the file is valid
        if ($request->has('nof') || $request->file('file')->isValid()) {
            if ($request->has('wf')) {
             // Store the file in the 'uploads' directory on the 'public' disk
                $filePath = $request->file('file')->store('uploads', 'public');
                $info=explode("/",$filePath);
                $filereal=$info[1];
            } else {$filereal="";$filePath="";}

            $uploads=new uploads;
            $uploads->id_user=$id_user;
            $uploads->id_molecola=$id_molecola;
            $uploads->id_pack=$id_pack;
            $uploads->filereal=$filereal;
            $uploads->testo_ref=$testo_ref;

            $uploads->culture_date=$culture_date;
            $uploads->species_name=$species_name;
            $uploads->infection_source=$infection_source;
            $uploads->test_method=$test_method;
            $uploads->test_result=$test_result;

            $uploads->save();            
            // Return success response
            return back()->with('success', 'Form sent successfully')->with('file', $filePath);
        } 


        return back()->with('error', 'File upload failed');
      
        
    }
}
?>