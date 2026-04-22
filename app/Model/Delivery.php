<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'quantity', 'supplier', 'date'];

    public function product()
{
    return \Model\Product::where('name', $this->name)->first();
}
    
}