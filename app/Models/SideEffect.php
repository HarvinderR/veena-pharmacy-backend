<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SideEffect extends Model
{
    protected $table = 'side_effects';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
