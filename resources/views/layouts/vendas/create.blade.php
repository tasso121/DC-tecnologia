
@extends('layouts.app')

@section('titulo', 'Nova Venda')

@section('conteudo')
    <h1>Nova Venda</h1>

    <form method="POST" action="{{ route('vendas.store') }}">
        @csrf

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select">
                <option value="">Selecione</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Forma de Pagamento</label>
            <input type="text" name="forma_pagamento" class="form-control" required>
        </div>

        <h4>Produtos</h4>
        <div id="produtos"></div>
        <button type="button" id="adicionar-produto" class="btn btn-sm btn-outline-primary mb-3">Adicionar Produto</button>

        <h4>Parcelas</h4>
        <div id="parcelas"></div>
        <button type="button" id="adicionar-parcela" class="btn btn-sm btn-outline-secondary mb-3">Adicionar Parcela</button>

        <button type="submit" class="btn btn-success">Salvar Venda</button>
    </form>

    <template id="template-produto">
        <div class="row mb-2">
            <div class="col">
                <input type="text" name="produtos[][nome]" class="form-control" placeholder="Produto">
            </div>
            <div class="col">
                <input type="number" name="produtos[][quantidade]" class="form-control" placeholder="Qtd">
            </div>
            <div class="col">
                <input type="number" name="produtos[][preco]" class="form-control" placeholder="Preço" step="0.01">
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger remover-produto">X</button>
            </div>
        </div>
    </template>

    <template id="template-parcela">
        <div class="row mb-2">
            <div class="col">
                <input type="date" name="parcelas[][data_vencimento]" class="form-control">
            </div>
            <div class="col">
                <input type="number" name="parcelas[][valor]" class="form-control" placeholder="Valor" step="0.01">
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger remover-parcela">X</button>
            </div>
        </div>
    </template>

    <script>
        $(document).ready(function() {
            $('#adicionar-produto').click(function() {
                const template = $('#template-produto').html();
                $('#produtos').append(template);
            });

            $('#adicionar-parcela').click(function() {
                const template = $('#template-parcela').html();
                $('#parcelas').append(template);
            });

            $(document).on('click', '.remover-produto', function() {
                $(this).closest('.row').remove();
            });

            $(document).on('click', '.remover-parcela', function() {
                $(this).closest('.row').remove();
            });
        });
    </script>
@endsection
