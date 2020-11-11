<?php

namespace App\Http\Middleware;

use App\Imports\ProductsImport;
use Closure;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportProcessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        // Store the session data...
        if($response->getSession()->get('success') != null && $response->getSession()->get('success') != ""){
            /*$file_url = public_path('file').DIRECTORY_SEPARATOR.$request->file->getClientOriginalName();
            Excel::import(new ProductsImport(), $file_url);*/
        }
    }
}
