<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    //

    public function fileUploadPost(Request $request)
    {
        //return "['Harvinder':'rathor']";
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip',
        ]);

        $fileName = time().'.'.$request->file->getClientOriginalName();
        echo $request->file->hashName();
        echo $request->file->getClientOriginalName();
        $request->file->move(public_path('file'), $fileName);

        /* Store $fileName name in DATABASE from HERE */
        //File::create(['name' => $fileName]);

        //return "{'response':'success'}";
    }
}
