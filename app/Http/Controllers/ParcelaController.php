<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
use Illuminate\Http\Request;

class ParcelaController extends Controller
{
    public function marcarComoPaga(Parcela $parcela)
    {
        $parcela->update(['paga' => true]);
        return back()->with('sucesso', 'Parcela marcada como paga.');
    }
}
