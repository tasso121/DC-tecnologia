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

        <p><strong>Total da Venda:</strong> R$ <span id="total-venda">0,00</span></p>

        <div class="mb-3">
            <label for="qtd_parcelas" class="form-label">Quantidade de Parcelas</label>
            <input type="number" id="qtd_parcelas" class="form-control" min="1" max="36" placeholder="Ex: 3">
        </div>
        <button type="button" id="gerar-parcelas" class="btn btn-sm btn-outline-success mb-3">Gerar Parcelas</button>

        <h4>Parcelas</h4>
        <div id="parcelas"></div>
        <button type="button" id="adicionar-parcela" class="btn btn-sm btn-outline-secondary mb-3">Adicionar Parcela</button>

        <input type="hidden" name="valor_total" id="valor_total_hidden">
        <button type="submit" class="btn btn-success">Salvar Venda</button>
    </form>

    <template id="template-produto">
        <div class="row mb-2">
            <div class="col">
                <input type="text" name="produtos[0][nome]" class="form-control" placeholder="Produto">
            </div>
            <div class="col">
                <input type="number" name="produtos[0][quantidade]" class="form-control" placeholder="Qtd">
            </div>
            <div class="col">
                <input type="number" name="produtos[0][preco]" class="form-control" placeholder="Preço" step="0.01">
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
            function atualizarTotalVenda() {
                let total = 0;
                $('#produtos .row').each(function () {
                    const qtd = parseFloat($(this).find('input[name*="[quantidade]"]').val()) || 0;
                    const preco = parseFloat($(this).find('input[name*="[preco]"]').val()) || 0;
                    total += qtd * preco;
                });
                $('#total-venda').text(total.toFixed(2).replace('.', ','));
                $('#valor_total_hidden').val(total.toFixed(2)); 
            }

            function gerarParcelasAutomaticamente() {
                const qtd = parseInt($('#qtd_parcelas').val());
                if (!qtd || qtd <= 0) return;

                const totalStr = $('#total-venda').text().replace('R$', '').replace(',', '.');
                const total = parseFloat(totalStr) || 0;

                if (total <= 0) {
                    alert('Total da venda inválido. Adicione produtos primeiro.');
                    return;
                }

                const valorParcela = (total / qtd).toFixed(2);
                $('#parcelas').empty();

                for (let i = 0; i < qtd; i++) {
                    const data = new Date();
                    data.setMonth(data.getMonth() + i); // vencimento a cada mês
                    const dataFormatada = data.toISOString().split('T')[0];

                    const template = `
                        <div class="row mb-2">
                            <div class="col">
                                <input type="date" name="parcelas[][data_vencimento]" class="form-control" value="${dataFormatada}">
                            </div>
                            <div class="col">
                                <input type="number" name="parcelas[][valor]" class="form-control" value="${valorParcela}" step="0.01">
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger remover-parcela">X</button>
                            </div>
                        </div>
                    `;
                    $('#parcelas').append(template);
                }
            }

            $('#adicionar-produto').click(function() {
                const template = $('#template-produto').html();
                $('#produtos').append(template);
                setTimeout(atualizarTotalVenda, 100);
            });

            $('#adicionar-parcela').click(function() {
                const template = $('#template-parcela').html();
                $('#parcelas').append(template);
            });

            $('#gerar-parcelas').click(gerarParcelasAutomaticamente);

            $(document).on('input', 'input[name*="[quantidade]"], input[name*="[preco]"]', atualizarTotalVenda);

            $(document).on('click', '.remover-produto', function() {
                $(this).closest('.row').remove();
                atualizarTotalVenda();
            });

            $(document).on('click', '.remover-parcela', function() {
                $(this).closest('.row').remove();
            });
        });
    </script>
@endsection
