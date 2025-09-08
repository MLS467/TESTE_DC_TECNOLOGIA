<table class="table" id="dataTable">
    <thead>
        <tr class="text-center">

            @foreach ($columns as $column)
            <th scope="col">{{ $column }}</th>
            @endforeach
            <th scope="col">Ações</th>

        </tr>
    </thead>
    <tbody id="tbody">
        @if (!$values || count($values) === 0)
        <tr class="text-center">
            <td colspan="{{ count($columns) }}">No data available</td>
        </tr>
        @else


        @foreach ($values as $item)
        <tr class="text-center">
            <td>{{ $item[$keysValue[0]] }}</td>
            <td>{{ $item[$keysValue[1]] }}</td>
            <td>{{ $item[$keysValue[2]] }}</td>
            <td>
                @if ($title === 'Cliente')
                <form action="{{ route('client.destroy', $item[$keysValue[0]]) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Deletar</button>
                </form>
                <a href="{{ route('client.edit', $item[$keysValue[0]]) }}" class="btn btn-warning btn-sm">Atualizar</a>
                @else
                <form action="{{ route('product.destroy', $item[$keysValue[0]]) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Deletar</button>
                </form>
                <a href="{{ route('product.edit', $item[$keysValue[0]]) }}" class="btn btn-warning btn-sm">Atualizar</a>
                @endif
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>