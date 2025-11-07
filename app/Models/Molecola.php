<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Molecola extends Model
{
    use HasFactory;
//
    protected $table = 'molecola';
    protected $fillable = ['descrizione', 'info'];
}