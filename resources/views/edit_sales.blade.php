<x-layout.main>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Editar Venda</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="client_id" value="{{ $sale->client_id }}">
                    <input type="hidden" name="total_amount" value="{{ $sale->total_amount }}">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sale_date" class="form-label">Data da Venda</label>
                                <input type="date" class="form-control" id="sale_date" name="sale_date"
                                    value="{{ old('sale_date', $sale->sale_date) }}">
                                @error('sale_date')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="number_of_installments" class="form-label">Número de Parcelas</label>
                                <input type="number" class="form-control" id="number_of_installments"
                                    name="number_of_installments" min="1" max="12"
                                    value="{{ old('number_of_installments', $sale->number_of_installments) }}" readonly>
                                @error('number_of_installments')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="client_name" class="form-label">Nome do Cliente</label>
                                <input type="text" class="form-control" id="client_name" name="client_name"
                                    value="{{ old('client_name', $sale->client->name) }}">
                                @error('client_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="client_cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="client_cpf" name="client_cpf"
                                    value="{{ old('client_cpf', $sale->client->cpf) }}">
                                @error('client_cpf')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Valor Total da Venda</label>
                        <input type="text" class="form-control bg-light"
                            value="R$ {{ number_format($sale->total_amount, 2, ',', '.') }}" readonly>
                    </div>

                    <!-- Seção de Produtos -->
                    <div class="card border-secondary">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">Produtos da Venda</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($sale->salesItems as $index => $item)
                            <!-- Hidden fields para manter os IDs -->
                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                            <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">

                            <div class="border rounded p-3 mb-3 {{ $loop->last ? '' : 'border-bottom' }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Nome do Produto</label>
                                            <input type="text" class="form-control" value="{{ $item->product->name }}"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Quantidade</label>
                                            <input type="number" class="form-control"
                                                name="items[{{ $index }}][quantity]"
                                                value="{{ old('items.'.$index.'.quantity', $item->quantity) }}" min="1"
                                                required readonly>
                                            @error('items.'.$index.'.quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Preço Unitário</label>
                                            <input type="number" class="form-control"
                                                name="items[{{ $index }}][unit_price]"
                                                value="{{ old('items.'.$index.'.unit_price', $item->unit_price) }}"
                                                step="0.01" min="0" readonly>
                                            @error('items.'.$index.'.unit_price')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Total do Item</label>
                                            <input type="text" class="form-control bg-light"
                                                value="R$ {{ number_format($item->total_price, 2, ',', '.') }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card border-info mt-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Parcelas da Venda</h5>
                        </div>
                        <div class="card-body">
                            @if($sale->installments && count($sale->installments) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Parcela</th>
                                            <th scope="col">Valor</th>
                                            <th scope="col">Data de Vencimento</th>
                                            <th scope="col">Tipo de Pagamento</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sale->installments as $index => $installment)
                                        @php
                                        $isPaid = is_object($installment) ? $installment->is_paid :
                                        ($installment['is_paid'] ?? false);
                                        $dueDate = is_object($installment) ? $installment->due_date :
                                        ($installment['due_date'] ?? now());
                                        $amount = is_object($installment) ? $installment->amount :
                                        ($installment['amount'] ?? 0);
                                        $paymentType = is_object($installment) ? $installment->payment_type :
                                        ($installment['payment_type'] ?? 'pending');
                                        @endphp
                                        <tr
                                            class="{{ $isPaid ? 'table-success' : (\Carbon\Carbon::parse($dueDate) < now() ? 'table-danger' : '') }}">
                                            <td>
                                                <strong>{{ $index + 1 }}º Parcela</strong>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">
                                                    R$ {{ number_format($amount, 2, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($dueDate)->format('d/m/Y') }}
                                                @if(\Carbon\Carbon::parse($dueDate) < now() && !$isPaid) <small
                                                    class="text-danger">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    ({{ \Carbon\Carbon::parse($dueDate)->diffForHumans() }})
                                                    </small>
                                                    @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst($paymentType) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($isPaid)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle"></i> Pago
                                                </span>
                                                @else
                                                @if(\Carbon\Carbon::parse($dueDate) < now()) <span
                                                    class="badge bg-danger">
                                                    <i class="fas fa-clock"></i> Vencido
                                                    </span>
                                                    @else
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-hourglass-half"></i> Pendente
                                                    </span>
                                                    @endif
                                                    @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-warning" onclick="saveFormDataAndRedirect()">
                                        Atualizar Parcelas
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">Total de Parcelas</h6>
                                            <h4 class="text-primary">{{ count($sale->installments) }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">Parcelas Pagas</h6>
                                            <h4 class="text-success">
                                                @php
                                                $paidCount = 0;
                                                foreach($sale->installments as $inst) {
                                                $isPaidInst = is_object($inst) ? $inst->is_paid : ($inst['is_paid'] ??
                                                false);
                                                if($isPaidInst) $paidCount++;
                                                }
                                                @endphp
                                                {{ $paidCount }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">Parcelas Pendentes</h6>
                                            <h4 class="text-warning">
                                                {{ count($sale->installments) - $paidCount }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle"></i>
                                Nenhuma parcela encontrada para esta venda.
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('sales.cancel_edit') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('input[name*="[quantity]"]');
            const priceInputs = document.querySelectorAll('input[name*="[unit_price]"]');
            const installmentsInput = document.getElementById('number_of_installments');

            const installmentRows = document.querySelectorAll('tbody tr');
            if (installmentsInput && installmentRows.length > 0) {
                installmentsInput.value = installmentRows.length;
            }

            function updateTotals() {
                let grandTotal = 0;

                quantityInputs.forEach((qtyInput, index) => {
                    const priceInput = priceInputs[index];
                    const qty = parseFloat(qtyInput.value) || 0;
                    const price = parseFloat(priceInput.value) || 0;
                    const total = qty * price;

                    const totalField = document.querySelector(
                        `input[readonly][value*="R$"]:nth-of-type(${index + 1})`);
                    if (totalField) {
                        totalField.value =
                            `R$ ${total.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
                    }

                    grandTotal += total;
                });

                document.querySelector('input[name="total_amount"]').value = grandTotal.toFixed(2);
                const totalDisplay = document.querySelector('input[readonly][value*="R$"]:last-of-type');
                if (totalDisplay) {
                    totalDisplay.value = `R$ ${grandTotal.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
                }
            }

            if (installmentsInput) {
                installmentsInput.addEventListener('change', function() {
                    console.log('Número de parcelas alterado para:', this.value);
                });
            }

            [...quantityInputs, ...priceInputs].forEach(input => {
                input.addEventListener('input', updateTotals);
            });
        });

        // Função para salvar dados do formulário na sessão antes de ir para parcelas
        function saveFormDataAndRedirect() {
            const formData = {
                sale_date: document.getElementById('sale_date').value,
                client_name: document.getElementById('client_name').value,
                client_cpf: document.getElementById('client_cpf').value,
                number_of_installments: document.getElementById('number_of_installments').value
            };

            fetch('{{ route("sales.save_form_data") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(formData)
            }).then(() => {
                window.location.href = '{{ route("edit_installments") }}';
            });
        }
    </script>

</x-layout.main>