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
                                    value="{{ old('sale_date', $sale->sale_date) }}" required>
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
                                    value="{{ old('number_of_installments', $sale->number_of_installments) }}" required>
                                @error('number_of_installments')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nome do Cliente</label>
                                <input type="text" class="form-control" value="{{ $sale->client->name }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CPF</label>
                                <input type="text" class="form-control" value="{{ $sale->client->cpf }}" readonly>
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
                                                required>
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
                                                step="0.01" min="0" required>
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

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
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

        [...quantityInputs, ...priceInputs].forEach(input => {
            input.addEventListener('input', updateTotals);
        });
    });
    </script>

</x-layout.main>