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
                    <option value="{{ $cliente->id }}" {{ $cliente->id == $venda->cliente_id ? 'selected' : '' }}>
                        {{ $cliente->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Forma de Pagamento</label>
            <input type="text" name="forma_pagamento" class="form-control" value="{{ $venda->forma_pagamento }}" required>
        </div>

        <h4>Produtos</h4>
        <div id="produtos">
            @php $produtoIndex = 0; @endphp
            @foreach($venda->itens as $item)
                <div class="row mb-2" data-produto-index="{{ $produtoIndex }}">
                    <div class="col">
                        <input type="text" name="produtos[{{ $produtoIndex }}][nome]" 
                               class="form-control"
                               value="{{ $item->produto }}">
                    </div>
                    <div class="col">
                        <input type="number" name="produtos[{{ $produtoIndex }}][quantidade]"
                               class="form-control"
                               value="{{ $item->quantidade }}">
                    </div>
                    <div class="col">
                        <input type="number" name="produtos[{{ $produtoIndex }}][preco]"
                               class="form-control"
                               value="{{ $item->preco_unitario }}"
                               step="0.01">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger remover-produto">X</button>
                    </div>
                </div>
                @php $produtoIndex++; @endphp
            @endforeach
        </div>
        <button type="button" id="adicionar-produto" class="btn btn-sm btn-outline-primary mb-3">Adicionar Produto</button>

        <p><strong>Total da Venda:</strong> R$ <span id="total-venda">0,00</span></p>

        <div class="mb-3">
            <label for="qtd_parcelas" class="form-label">Quantidade de Parcelas</label>
            <input type="number" id="qtd_parcelas" class="form-control" min="1" max="36" placeholder="Ex: 3">
        </div>
        <button type="button" id="gerar-parcelas" class="btn btn-sm btn-outline-success mb-3">Gerar Parcelas</button>

        <h4>Parcelas</h4>
        <div id="parcelas">
            @php $parcelaIndex = 0; @endphp
            @foreach($venda->parcelas as $parcela)
                <div class="row mb-2" data-parcela-index="{{ $parcelaIndex }}">
                    <div class="col">
                        <input type="date" name="parcelas[{{ $parcelaIndex }}][data_vencimento]"
                               class="form-control"
                               value="{{ $parcela->data_vencimento }}">
                    </div>
                    <div class="col">
                        <input type="number" name="parcelas[{{ $parcelaIndex }}][valor]"
                               class="form-control"
                               value="{{ $parcela->valor }}"
                               step="0.01">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger remover-parcela">X</button>
                    </div>
                </div>
                @php $parcelaIndex++; @endphp
            @endforeach
        </div>
        <button type="button" id="adicionar-parcela" class="btn btn-sm btn-outline-secondary mb-3">Adicionar Parcela</button>

        <button type="submit" class="btn btn-success">Atualizar Venda</button>
    </form>

    <script>
        let produtoIndex = {{ $produtoIndex }};
        let parcelaIndex = {{ $parcelaIndex }};

        function atualizarTotalVenda() {
            let total = 0;
            document.querySelectorAll('#produtos .row').forEach(function(row) {
                const qtd = parseFloat(row.querySelector('[name*=\"[quantidade]\"]').value) || 0;
                const preco = parseFloat(row.querySelector('[name*=\"[preco]\"]').value) || 0;
                total += (qtd * preco);
            });
            const valorFormatado = total.toFixed(2).replace('.', ',');
            document.getElementById('total-venda').innerText = valorFormatado;
        }

        function gerarParcelasAutomaticamente() {
            const qtdElement = document.getElementById('qtd_parcelas');
            const qtd = parseInt(qtdElement.value);
            if (!qtd || qtd <= 0) return;

            const totalVendaStr = document.getElementById('total-venda').innerText.replace('R$', '').replace(',', '.');
            const total = parseFloat(totalVendaStr) || 0;
            if (total <= 0) {
                alert('Total da venda inválido. Adicione produtos primeiro.');
                return;
            }
            const valorParcela = (total / qtd).toFixed(2);

            const parcelasDiv = document.getElementById('parcelas');
            parcelasDiv.innerHTML = '';

            for (let i = 0; i < qtd; i++) {
                const data = new Date();
                data.setMonth(data.getMonth() + i);
                const dataFormatada = data.toISOString().split('T')[0];

                const row = document.createElement('div');
                row.classList.add('row', 'mb-2');
                row.innerHTML = `
                    <div class="col">
                        <input type="date" name="parcelas[${parcelaIndex}][data_vencimento]" class="form-control" value="${dataFormatada}">
                    </div>
                    <div class="col">
                        <input type="number" name="parcelas[${parcelaIndex}][valor]" class="form-control" value="${valorParcela}" step="0.01">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger remover-parcela">X</button>
                    </div>
                `;
                parcelasDiv.appendChild(row);
                parcelaIndex++;
            }
        }

        function adicionarProduto() {
            const row = document.createElement('div');
            row.classList.add('row', 'mb-2');
            row.setAttribute('data-produto-index', produtoIndex);

            row.innerHTML = `
                <div class="col">
                    <input type="text" name="produtos[${produtoIndex}][nome]" class="form-control" placeholder="Produto">
                </div>
                <div class="col">
                    <input type="number" name="produtos[${produtoIndex}][quantidade]" class="form-control" placeholder="Qtd">
                </div>
                <div class="col">
                    <input type="number" name="produtos[${produtoIndex}][preco]" class="form-control" placeholder="Preço" step="0.01">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger remover-produto">X</button>
                </div>
            `;

            document.getElementById('produtos').appendChild(row);
            produtoIndex++;
            setTimeout(atualizarTotalVenda, 100);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('adicionar-produto').addEventListener('click', adicionarProduto);

            document.getElementById('gerar-parcelas').addEventListener('click', gerarParcelasAutomaticamente);

            document.getElementById('adicionar-parcela').addEventListener('click', function() {
                const row = document.createElement('div');
                row.classList.add('row', 'mb-2');
                row.innerHTML = `
                    <div class="col">
                        <input type="date" name="parcelas[${parcelaIndex}][data_vencimento]" class="form-control">
                    </div>
                    <div class="col">
                        <input type="number" name="parcelas[${parcelaIndex}][valor]" class="form-control" placeholder="Valor" step="0.01">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger remover-parcela">X</button>
                    </div>
                `;
                document.getElementById('parcelas').appendChild(row);
                parcelaIndex++;
            });

            document.addEventListener('click', function(e) {
                if(e.target.classList.contains('remover-produto')) {
                    e.target.closest('.row').remove();
                    atualizarTotalVenda();
                }
                if(e.target.classList.contains('remover-parcela')) {
                    e.target.closest('.row').remove();
                }
            });

            document.addEventListener('input', function(e) {
                if(e.target.matches('input[name*="[quantidade]"], input[name*="[preco]"]')) {
                    atualizarTotalVenda();
                }
            });

            atualizarTotalVenda();
        });
    </script>
@endsection
