<x-layout.main>
    <div class="container mt-5">

        <table class="table">
            <thead>
                <tr class="text-center">
                    <th scope="col">#</th>
                    <th scope="col">Nome Cliente</th>
                    <th scope="col">Data da Venda</th>
                    <th scope="col">Parcelas</th>
                    <th scope="col">Valor Integral</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                <tr class="text-center">
                    <th scope="row">{{ $sale->id }}</th>
                    <td>{{ $sale->client->name }}</td>
                    <td>{{ $sale->sale_date }}</td>
                    <td>{{ $sale->number_of_installments }}</td>
                    <td>{{ $sale->total_amount }}</td>
                    <td class="d-flex gap-2">
                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                            onsubmit="return confirm('Tem certeza que deseja excluir?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>

                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <a href="{{ route('sales.print') }}" class="btn btn-info btn-sm">
                            <i class="bi bi-printer"></i>
                        </a>
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>

    </div>


</x-layout.main>