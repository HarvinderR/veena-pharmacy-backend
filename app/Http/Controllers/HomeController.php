<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Process\Process;

class HomeController extends Controller
{
    //
    function home(){
        return view('home');
    }

    function viewCategory(){
        return view('viewCategory');
    }

    function createCategory(){
        return view('createCategory');
    }

    function uploadProducts(){
        return view('uploadProducts');
    }

    function deleteCat(Request $request){
        $cat_id = $request->id;
        DB::table('categories')->where('id',$cat_id)->delete();
        DB::table('r_cat_prod')->where('cat_id',$cat_id)->delete();
        return ["response"=>"success"];
    }
    function getProductsByCat(Request $request){
        $cat_id = $request->id;
        $res = DB::select('select r_cat_prod.cat_id, products.id,products.name,products.salt from r_cat_prod right JOIN products on r_cat_prod.prod_id = products.id WHERE r_cat_prod.cat_id=? ',[$cat_id]);
        return $res;
    }

    function getAllCategories(){
        $cat = Category::all();
        return $cat;
    }

    function saveCategory(Request $request){
        $catName = $request->data['name'];
        $catTitle = $request->data['title'];
        $category = new Category();
        $category->name = $catName;
        $category->title = $catTitle;
        $category->save();
        $req_products = $request->data['products'];
        foreach ($req_products as $req_product) {
            DB::table('r_cat_prod')->insert(['cat_id'=> $category->id,'prod_id'=> $req_product['id']  ]);
        }
        echo "Something";
    }

    function searchProducts(Request $request){
        $data = $request->get('data');

        $products = Product::select('id','name')->where('name', 'like', "%{$data}%")
            ->orWhere('salt', 'like', "%{$data}%")
            ->take(5)
            ->get();
        return $products;
    }

    function editProductItem(Request $request){
        $product = Product::where('id',$request->id)->first();
        $product->name = $request->name;
        $product->salt = $request->salt;
        $product->price = $request->price;
        $product->save();
        return $request -> all();
    }

    function bulkProductItem(Request $request){
        $data = $request->data;
        foreach ($data as $value){
            $product = Product::where('id',$value['id'])->first();
            $product->name = $value['name'];
            $product->salt = $value['salt'];
            $product->price = $value['price'];
            $product->save();
        }
        return $data;
    }

    function viewProducts(){
        $product = \App\Models\Product::paginate(15);
        return view('ViewProduct',compact('product')  );
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
