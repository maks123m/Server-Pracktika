<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class WriteOff extends Model
{
    public $timestamps = false;
    protected $fillable = ['product_id', 'name', 'quantity', 'employee', 'department', 'date'];
}