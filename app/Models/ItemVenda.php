<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemVenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'venda_id',
        'produto',
        'quantidade',
        'preco_unitario',
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }
}
