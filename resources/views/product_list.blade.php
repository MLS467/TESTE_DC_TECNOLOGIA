<x-layout.main>
    <div class="container mt-5">

        <x-table.table :values="$data_value" :columns="$columns" :title="$title" :keys_value="$keys_value" />

    </div>
</x-layout.main>