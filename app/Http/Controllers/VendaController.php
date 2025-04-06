<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Cliente;
use App\Models\ItemVenda;
use App\Models\Parcela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Venda::with('cliente', 'usuario');

        if ($request->has('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->cliente . '%');
            });
        }

        $vendas = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('vendas.index', compact('vendas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('vendas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $venda = Venda::create([
            'cliente_id' => $request->cliente_id,
            'usuario_id' => Auth::id(),
            'valor_total' => 0, // Será atualizado depois
            'forma_pagamento' => $request->forma_pagamento,
        ]);
    
        $valorTotal = 0;
    
        if ($request->has('produtos')) {
            foreach ($request->produtos as $produto) {
                if (!isset($produto['nome'], $produto['quantidade'], $produto['preco'])) {
                    continue;
                }
    
                $quantidade = floatval($produto['quantidade']);
                $preco = floatval($produto['preco']);
                $subtotal = $quantidade * $preco;
    
                ItemVenda::create([
                    'venda_id' => $venda->id,
                    'produto' => $produto['nome'],
                    'quantidade' => $quantidade,
                    'preco_unitario' => $preco,
                ]);
                $subtotal = $quantidade * $preco;
                $valorTotal += $subtotal;
            }
        }
    
        if ($request->has('parcelas')) {
            foreach ($request->parcelas as $parcela) {
                if (!isset($parcela['data_vencimento'], $parcela['valor'])) {
                    continue;
                }
    
                Parcela::create([
                    'venda_id' => $venda->id,
                    'data_vencimento' => $parcela['data_vencimento'],
                    'valor' => $parcela['valor'],
                ]);
            }
        }
    
        $venda->update(['valor_total' => $valorTotal]);
    
        return redirect()->route('vendas.index')->with('sucesso', 'Venda cadastrada com sucesso!');
    }
    

    public function edit(Venda $venda)
    {
        $clientes = Cliente::all();
        $venda->load('itens', 'parcelas');
        return view('vendas.edit', compact('venda', 'clientes'));
    }

    public function update(Request $request, Venda $venda)
    {
        $venda->update($request->only(['cliente_id', 'forma_pagamento']));

        $venda->itens()->delete();
        $venda->parcelas()->delete();

        $valorTotal = 0;

        foreach ($request->produtos as $produto) {
            if (isset($produto['nome'], $produto['quantidade'], $produto['preco'])) {
                $quantidade = floatval($produto['quantidade']);
                $preco = floatval($produto['preco']);
                $subtotal = $quantidade * $preco;
                
                $item = new ItemVenda([
                    'produto' => $produto['nome'],
                    'quantidade' => $produto['quantidade'],
                    'preco_unitario' => $produto['preco'],
                ]);
                $item->venda()->associate($venda);
                $item->save();
        
                $subtotal = $quantidade * $preco;
                $valorTotal += $subtotal;
            }
        }
        

        foreach ($request->parcelas as $parcela) {
            if (isset($parcela['data_vencimento'], $parcela['valor'])) {
                $novaParcela = new Parcela([
                    'data_vencimento' => $parcela['data_vencimento'],
                    'valor' => $parcela['valor'],
                ]);
                $novaParcela->venda()->associate($venda);
                $novaParcela->save();
            }
        }
        

        $venda->update(['valor_total' => $valorTotal]);

        return redirect()->route('vendas.index')->with('sucesso', 'Venda atualizada com sucesso!');
    }

    public function destroy(Venda $venda)
    {
        $venda->delete();
        return redirect()->route('vendas.index')->with('sucesso', 'Venda excluída com sucesso!');
    }
}   