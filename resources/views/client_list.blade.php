<x-layout.main>
    <div class="container mt-5">

        <div class="container my-5 text-end">
            <input type="text" placeholder="Pesquisar..." id="tableFilter" class="form-control d-inline-block w-auto" />
        </div>

        <div class="container my-5 text-start">
            <a href="{{ route('client.create') }}" class="btn btn-success ">Adicionar Cliente</a>
        </div>

        <x-table.table :values="$data_value" :columns="$columns" :title="$title" :keys_value="$keys_value">

        </x-table.table>


        <script src="{{ asset('assets/js/filter/Filter.js')}}" type="module">

        </script>
    </div>
</x-layout.main>