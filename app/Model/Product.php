<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'sku', 'unit', 'quantity', 'min_norm'];
}