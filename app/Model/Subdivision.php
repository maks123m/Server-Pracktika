<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Subdivision extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}