<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allestimento extends Model
{
    use HasFactory;
 
    protected $table = 'allestimento';
    protected $fillable = [
        'id_molecola',
        'id_pack',
        'id_pack_qty',
        'cod_liof',
        'descrizione',
        'stock',
        'remaining',
    ];

    public function molecola()
    {
        return $this->belongsTo(Molecola::class, 'id_molecola');
    }

    public function packaging()
    {
        return $this->belongsTo(Packaging::class, 'id_pack');
    }

    public function packQty()
    {
        return $this->belongsTo(PackQty::class, 'id_pack_qty');
    }
}