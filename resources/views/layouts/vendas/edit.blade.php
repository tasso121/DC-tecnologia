@extends('layouts.app')

@section('titulo', 'Editar Venda')

@section('conteudo')
    <h1>Editar Venda #{{ $venda->id }}</h1>

    <form method="POST" action="{{ route('vendas.update', $venda) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-select">
                <option value="">Selecione</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ $cliente->id == $venda->cliente_id ? 'selected' : '' }}>{{ $cliente->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Forma de Pagamento</label>
            <input type="text" name="forma_pagamento" class="form-control" value="{{ $venda->forma_pagamento }}" required>
        </div>

        <h4>Produtos</h4>
        <div id="produtos">
            @foreach($venda->itens as $item)
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" name="produtos[][nome]" class="form-control" value="{{ $item->produto }}">
                    </div>
                    <div class="col">
                        <input type="number" name="produtos[][quantidade]" class="form-control" value="{{ $item->quantidade }}">
                    </div>
                    <div class="col">
                        <input type="number" name="produtos[][preco]" class="form-control" value="{{ $item->preco_unitario }}" step="0.01">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger remover-produto">X</button>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" id="adicionar-produto" class="btn btn-sm btn-outline-primary mb-3">Adicionar Produto</button>

        <h4>Parcelas</h4>
        <div id="parcelas">
            @foreach($venda->parcelas as $parcela)
                <div class="row mb-2">
                    <div class="col">
                        <input type="date" name="parcelas[][data_vencimento]" class="form-control" value="{{ $parcela->data_vencimento }}">
                    </div>
                    <div class="col">
                        <input type="number" name="parcelas[][valor]" class="form-control" value="{{ $parcela->valor }}" step="0.01">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger remover-parcela">X</button>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" id="adicionar-parcela" class="btn btn-sm btn-outline-secondary mb-3">Adicionar Parcela</button>

        <button type="submit" class="btn btn-success">Atualizar Venda</button>
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