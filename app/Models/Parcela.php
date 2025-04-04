<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parcela extends Model
{
    use HasFactory;

    protected $fillable = [
        'venda_id',
        'data_vencimento',
        'valor',
        'paga',
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }
}
