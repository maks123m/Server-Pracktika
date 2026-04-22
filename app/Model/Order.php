<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'quantity', 'supplier', 'status'];
}