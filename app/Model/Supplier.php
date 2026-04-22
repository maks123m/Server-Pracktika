<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'contact_person', 'phone'];
}