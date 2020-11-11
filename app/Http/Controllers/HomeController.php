<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Process\Process;

class HomeController extends Controller
{
    //
    function home(){
        return view('home');
    }

    function uploadProducts(){
        return view('uploadProducts');
    }

    function postUploadProducts(Request $request){
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip',
        ]);

        //$fileName = time().'.'.$request->file->extension();

        //$request->file->move(public_path('file'), $fileName);

        $request->file->move(public_path('file'), $request->file->getClientOriginalName());
        //You can choose to validate file type. e.g csv,xls,xlsx.

        $file_url = public_path('file').DIRECTORY_SEPARATOR.$request->file->getClientOriginalName();
        Excel::import(new ProductsImport(), $file_url);

        /* Store $fileName name in DATABASE from HERE */
        //File::create(['name' => $fileName])

        return back()
            ->with('success','You have successfully upload the file.')
            ->with('file',$request->file->getClientOriginalName());
    }
}
