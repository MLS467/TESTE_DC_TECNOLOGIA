<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/printStyle.css') }}">

    <title>{{ env('APP_NAME') }}</title>
</head>

<body class="bg-light">


    <div class="container mt-5">

        <div class="no-print print-btn">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> Imprimir
            </button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Fechar</a>
        </div>

        <div class="header">
            <h1>RELATÓRIO DE VENDAS</h1>
            <p>Data de Impressão: {{ date('d/m/Y H:i:s') }}</p>
            <p>Total de Vendas: {{ count($sale) }}</p>
        </div>

        @if(isset($sale) && count($sale) > 0)
        @foreach($sale as $index => $saleItem)
        <div class="sale-section {{ $index > 0 ? 'page-break' : '' }}">
            <div class="sales-info">
                <h3>Venda #{{ $saleItem->id }}</h3>

                <div class="info-row">
                    <span class="label">Data da Venda:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($saleItem->sale_date)->format('d/m/Y') }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Cliente:</span>
                    <span class="value">{{ $saleItem->client->name ?? 'N/A' }}</span>
                </div>

                <div class="info-row">
                    <span class="label">CPF:</span>
                    <span class="value">{{ $saleItem->client->cpf ?? 'N/A' }}</span>
                </div>

                <div class="info-row">
                    <span class="label">Número de Parcelas:</span>
                    <span class="value">{{ $saleItem->number_of_installments }}x</span>
                </div>
            </div>

            <h4>Itens da Venda</h4>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Descrição</th>
                        <th>Quantidade</th>
                        <th>Valor Unitário</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($saleItem->salesItems as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                        <td>{{ $item->product->description ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($item->total_price, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-section">
                <div class="info-row total-amount">
                    <span class="label">TOTAL:</span>
                    <span class="value">R$ {{ number_format($saleItem->total_amount, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endforeach

        <div class="total-section" style="margin-top: 30px;">
            <div class="info-row total-amount">
                <span class="label">TOTAL GERAL DE TODAS AS VENDAS:</span>
                <span class="value">R$ {{ number_format($sale->sum('total_amount'), 2, ',', '.') }}</span>
            </div>
        </div>
        @else
        <div class="alert alert-warning">
            <p>Nenhuma venda encontrada para impressão.</p>
        </div>
        @endif

    </div>

</body>

</html>