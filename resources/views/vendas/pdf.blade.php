<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resumo da Venda #{{ $venda->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h1>Resumo da Venda #{{ $venda->id }}</h1>

    <p><strong>Cliente:</strong> {{ $venda->cliente->nome ?? 'Não informado' }}</p>
    <p><strong>Forma de Pagamento:</strong> {{ $venda->forma_pagamento }}</p>
    <p><strong>Valor Total:</strong> R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</p>

    <h3>Itens Vendidos</h3>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venda->itens as $item)
                <tr>
                    <td>{{ $item->produto }}</td>
                    <td>{{ $item->quantidade }}</td>
                    <td>R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($item->quantidade * $item->preco_unitario, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Parcelas</h3>
    <table>
        <thead>
            <tr>
                <th>Data de Vencimento</th>
                <th>Valor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venda->parcelas as $parcela)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($parcela->data_vencimento)->format('d/m/Y') }}</td>
                    <td>R$ {{ number_format($parcela->valor, 2, ',', '.') }}</td>
                    <td>{{ $parcela->paga ? 'Paga' : 'Pendente' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>