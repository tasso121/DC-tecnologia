@extends('layouts.app')

@section('titulo', 'Lista de Vendas')

@section('conteudo')
    <h1>Vendas</h1>
    <a href="{{ route('vendas.create') }}" class="btn btn-primary mb-3">Nova Venda</a>

    <form method="GET" class="mb-3">
        <input type="text" name="cliente" class="form-control" placeholder="Buscar por cliente" value="{{ request('cliente') }}">
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Forma de Pagamento</th>
                <th>Valor Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vendas as $venda)
                <tr>
                    <td>{{ $venda->id }}</td>
                    <td>{{ $venda->cliente->nome ?? 'Não informado' }}</td>
                    <td>{{ $venda->forma_pagamento }}</td>
                    <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('vendas.edit', $venda) }}" class="btn btn-sm btn-warning">Editar</a>
                        <a href="{{ route('vendas.pdf', $venda) }}" class="btn btn-sm btn-secondary">PDF</a>
                        <form action="{{ route('vendas.destroy', $venda) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $vendas->links() }}
@endsection
