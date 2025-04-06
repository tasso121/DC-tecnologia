<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVendas = Venda::count();
        $valorTotalVendas = Venda::sum('valor_total');
        $ultimaVenda = Venda::latest()->with('cliente')->first();

        return view('dashboard', compact('totalVendas', 'valorTotalVendas', 'ultimaVenda'));
    }
}

