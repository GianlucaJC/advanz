<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackQty extends Model
{
    use HasFactory;

    protected $table = 'pack_qty';
    protected $fillable = ['id_pack', 'descrizione'];
}