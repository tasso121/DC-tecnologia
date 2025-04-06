@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('conteudo')
    <div class="container">
        <h1 class="mb-4">Dashboard</h1>

        @if (session('sucesso'))
            <div class="alert alert-success">{{ session('sucesso') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total de Vendas</h5>
                        <p class="card-text fs-3">{{ $totalVendas }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Valor Total Vendido</h5>
                        <p class="card-text fs-3">R$ {{ number_format($valorTotalVendas, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @if ($ultimaVenda)
            <div class="col-md-4">
                <div class="card text-white bg-dark mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Última Venda</h5>
                        <p class="card-text">
                            Cliente: <strong>{{ $ultimaVenda->cliente->nome ?? 'N/A' }}</strong><br>
                            Valor: <strong>R$ {{ number_format($ultimaVenda->valor_total, 2, ',', '.') }}</strong><br>
                            {{ $ultimaVenda->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Última Venda</h5>
                        <p class="card-text">Nenhuma venda registrada ainda.</p>
                    </div>
                </div>
            </div>
        @endif
        
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('vendas.create') }}" class="btn btn-outline-primary">Nova Venda</a>
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">Clientes</a>
        </div>
    </div>
@endsection
