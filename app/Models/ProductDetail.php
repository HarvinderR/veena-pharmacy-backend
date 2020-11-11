<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table = 'product_details';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
