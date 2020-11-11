<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempProduct extends Model
{
    protected $table = 'temp_products';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
