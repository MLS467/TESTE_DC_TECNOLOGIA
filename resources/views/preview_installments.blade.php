<x-layout.main>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">
                    <i class="fas fa-eye me-2"></i>Visualizar Parcelas da Venda
                </h4>
            </div>
            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Informações da Venda</h6>
                                <p class="mb-1"><strong>Cliente:</strong> {{ $client->name ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>CPF:</strong> {{ $client->cpf ?? 'N/A' }}</p>
                                <p class="mb-0"><strong>Total da Venda:</strong>
                                    <span class="text-success fw-bold">R$
                                        {{ number_format($total_amount, 2, ',', '.') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Resumo das Parcelas</h6>
                                <p class="mb-1"><strong>Quantidade:</strong> {{ count($installments) }}x</p>
                                <p class="mb-1"><strong>Valor por Parcela:</strong>
                                    R$ {{ number_format(collect($installments)->avg('valor'), 2, ',', '.') }}
                                </p>
                                <p class="mb-0"><strong>Data:</strong> {{ date('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>Detalhes das Parcelas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col" class="text-center">Parcela</th>
                                        <th scope="col" class="text-center">Valor</th>
                                        <th scope="col" class="text-center">Data de Vencimento</th>
                                        <th scope="col" class="text-center">Tipo de Pagamento</th>
                                        <th scope="col" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($installments as $index => $installment)
                                    <tr>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">{{ $index + 1 }}ª Parcela</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold text-success">
                                                R$ {{ number_format($installment['valor'], 2, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($installment['data'])->format('d/m/Y') }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info">
                                                {{ ucfirst($installment['tipo_pagamento'] === 'credit' ? 'Cartão de Crédito' : 'Dinheiro') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-hourglass-half"></i> Pendente
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Total de Parcelas</h6>
                                        <h4 class="text-primary">{{ count($installments) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Valor Total</h6>
                                        <h4 class="text-success">R$
                                            {{ number_format(collect($installments)->sum('valor'), 2, ',', '.') }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Status Geral</h6>
                                        <h4 class="text-warning">Pendente</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('new-sale') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>

                    <form action="{{ route('sales.store') }}" method="POST" style="display: inline;">
                        @csrf
                        <!-- Hidden fields com dados da sessão -->
                        <input type="hidden" name="id_client" value="{{ $client->id ?? '' }}">
                        <input type="hidden" name="subtotal" value="{{ $total_amount }}">

                        @foreach($installments as $index => $installment)
                        <input type="hidden" name="installments[{{ $index }}][valor]"
                            value="{{ $installment['valor'] }}">
                        <input type="hidden" name="installments[{{ $index }}][data]" value="{{ $installment['data'] }}">
                        <input type="hidden" name="installments[{{ $index }}][tipo_pagamento]"
                            value="{{ $installment['tipo_pagamento'] }}">
                        @endforeach

                        @if(isset($products))
                        @foreach($products as $index => $product)
                        <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product['id'] }}">
                        <input type="hidden" name="products[{{ $index }}][quantity]" value="{{ $product['quantity'] }}">
                        <input type="hidden" name="products[{{ $index }}][unit_value]"
                            value="{{ $product['unit_value'] }}">
                        @endforeach
                        @endif

                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save me-2"></i>Confirmar e Salvar Venda
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout.main>