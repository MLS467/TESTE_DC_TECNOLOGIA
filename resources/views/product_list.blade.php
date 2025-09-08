<x-layout.main>
    <div class="container mt-5">

        <div class="container my-5 text-end">
            <input type="text" placeholder="Pesquisar..." id="tableFilter" class="form-control d-inline-block w-auto" />
        </div>

        <div class="container my-5 text-start">
            <a href="{{ route('product.create') }}" class="btn btn-success ">Adicionar Produto</a>
        </div>

        <x-table.table :values="$data_value" :columns="$columns" :title="$title" :keys_value="$keys_value" />

    </div>

    <script src="{{ asset('assets/js/filter/Filter.js')}}" type="module">

    </script>
</x-layout.main>