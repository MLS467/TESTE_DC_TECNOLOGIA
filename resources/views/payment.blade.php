<x-layout.main>

    <h1>Pagamento</h1>
    <p>Por favor, complete seu pagamento.</p>

    <form action="{{ route('sales.store') }}" method="post" id="form_payment">
        @csrf
        <div id="hiddenFields"></div>
        <div class="container w-50">
            <div class="row g-3 align-items-end mb-3">
                <div class="col">
                    <label for="subtotal" class="form-label">Subtotal</label>
                    <input type="text" class="form-control" id="subtotal" disabled>
                </div>
                <div class="col">
                    <label for="quantity_installments" class="form-label">Quantidade de parcelas</label>
                    <input type="number" class="form-control" id="quantity_installments" placeholder="Digite o valor">
                </div>
                <div class="col-auto">
                    <button id="btn_add_installments" class="btn btn-primary w-100">Adicionar</button>
                </div>
            </div>
            <div id="installment" class="row g-3"></div>
            <div class="w-100 text-end">
                <button type="submit" class="btn btn-success mt-5">Salvar</button>
                <button type="reset" onclick="location.reload()" class="btn btn-warning mt-5">Cancelar</button>
            </div>
        </div>

    </form>


    <script src="{{ asset('assets/js/payment/index.js') }}" type="module"></script>

</x-layout.main>