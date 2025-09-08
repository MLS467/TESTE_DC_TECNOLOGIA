<x-layout.main>

    <div class="container w-50 mt-3 p-3 border rounded shadow-sm bg-light">
        <div class="mb-3">
            <label for="clientSelect" class="form-label fw-bold">Cliente</label>
            <select id="clientSelect" class="form-select">
                <option selected disabled>Selecionar Cliente</option>
                @foreach ($clients as $client)
                <option value="{{ $client->id }}">
                    {{ $client->name }} - CPF: ***{{ substr($client->cpf, -4) }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="productSelect" class="form-label fw-bold">Produto</label>
                <select class="form-select" id="productSelect">
                    <option selected disabled>Selecionar Produto</option>
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} | R$ {{ number_format($product->price, 2, ',', '.') }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="quantity" class="form-label fw-bold">Quantidade</label>
                <input type="number" min="0" class="form-control" id="quantity" placeholder="Qtd">
            </div>

            <div class="col-md-2">
                <label for="unit_value" class="form-label fw-bold">Valor Unit.</label>
                <input type="text" class="form-control" id="unit_value" placeholder="R$">
            </div>

            <div class="col-md-2">
                <label for="subtotal" class="form-label fw-bold">Subtotal</label>
                <input type="text" class="form-control" id="subtotal" placeholder="R$">
            </div>

            <div class="col-md-2 d-grid">
                <button id="addProductButton" type="button" class="btn btn-success">
                    + Adicionar
                </button>
            </div>

            <div class="mt-4">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle text-center shadow-sm">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Valor Unitário</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="productsTableBody">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-5 text-end">
                <a href="{{ route('payment') }}" class="btn btn-success">Pagamento</a>
                <button class="btn btn-danger" id="clearProductsButton">Limpar</button>
            </div>

        </div>

        <script src="{{ asset('assets/js/new_sale/index.js') }}" type="module"></script>

</x-layout.main>