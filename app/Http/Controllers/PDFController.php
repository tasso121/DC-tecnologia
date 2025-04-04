<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function gerarResumo(Venda $venda)
    {
        $venda->load('cliente', 'itens', 'parcelas');

        $pdf = Pdf::loadView('vendas.pdf', compact('venda'));
        return $pdf->download('resumo-venda-' . $venda->id . '.pdf');
    }
}