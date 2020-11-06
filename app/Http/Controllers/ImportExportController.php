<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    //
    public function importExportView()
    {
        return 'importexport';
    }
    public function import()
    {
        //Excel::import(new BulkImport,request()->file('file'));

        return back();
    }

    function export(){
        return "export";
    }
}
