<?php

namespace App\Imports;

use App\Models\ProductDetail;
use App\Models\SideEffect;
use App\Models\TempProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Database\Schema\Blueprint;

class ProductsImport implements ToCollection
{

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $isDebug = false;
        //
        $isHeader=true;
        $tableName = "temp_products";
        $c = count($rows);

        if($c<=1){
            return;
        }
        try{
            TempProduct::query()->truncate();
            ProductDetail::query()->truncate();
            SideEffect::query()->truncate();
            echo "<br>truncate<br>";
            foreach ($rows as $row){
                if($isHeader){
                    if($isDebug){
                        echo $tableName;
                    }
                    /*Schema::dropIfExists($tableName);
                    Schema::connection('mysql')->create($tableName, function(Blueprint $table)
                    {
                        $table->increments('id');
                        $table->string('p_name')->nullable(false);
                        $table->string('p_size')->nullable();
                        $table->string('selling_price')->nullable();
                        $table->string('mrp')->nullable();
                        $table->string('category')->nullable();
                        $table->string('manufacture')->nullable();
                        $table->string('generic_name')->nullable();
                        $table->longText('product_detail')->nullable();
                        $table->longText('side_effect')->nullable();
                        $table->string('image')->nullable();
                        $table->string('prescription_required')->nullable();
                    });*/

                    $isHeader=false;
                }else{
                    //$array = array_values($row);

                    $r = new TempProduct();
                    $r->p_name =$row[0];
                    $r->p_size =$row[1];
                    $r->selling_price =$row[2];
                    $r->mrp =$row[3];
                    $r->category =$row[4];
                    $r->manufacture =$row[5];
                    $r->generic_name =$row[6];
                    $r->product_detail =$row[7];
                    $r->side_effect =$row[8];
                    $r->image =$row[9];
                    $r->prescription_required =$row[10];

                    $r->save();

                    $product_detail = explode(",",$row[7]);
                    foreach ($product_detail as $item) {
                        $p = new ProductDetail();
                        $p->pd_name = $item;
                        try{
                            $p->saveQuietly();
                        }catch (\Exception $e){
                            echo "type";
                            echo gettype($e);
                            echo 'Message: ' .$e->getMessage();
                            echo "<br>";
                            echo "<br>";
                        }
                    }

                    $side_effect = explode(",",$row[8]);
                    foreach ($side_effect as $item) {
                        $p = new SideEffect();
                        $p->se_name = $item;
                        try{
                            $p->saveQuietly();
                        }catch (\Exception $e){
                            echo 'Message:- ' .$e->getMessage();
                            echo "<br>";
                            echo "<br>";
                        }
                    }

                    /*$r = DB::insert('insert into '.$tableName.' (p_name,p_size,selling_price,mrp,category,manufacture,generic_name,product_detail,side_effect,image,prescription_required) values (?,?,?, ?,?,?,?, ?,?,?,?)',
                        [
                            '$row[0]',
                            '$row[1]',
                            '$row[2]',
                            '$row[3]',
                            '$row[4]',
                            '$row[5]',
                            '$row[6]',
                            '$row[7]',
                            '$row[8]',
                            '$row[9]',
                            '$row[10]',
    //                        $row[0],
                        ]);*/
                    if($isDebug){
                        echo $r;
                        echo "  ::  ";
                        echo $row[0].$row[3];
                        echo "<br><br>";
                    }
                }
            }
            if($isDebug){
                echo "<br><br>==================================<br>";
                $t = TempProduct::all();
                foreach ($t as $item) {
                    echo $item;
                    echo "<br>";
                }
            }
        }catch (\Exception $exception){
            echo 'Message:- ' .$exception->getMessage();
        }

    }


}
