<table class="table">
    <thead>
        <tr class="text-center">

            @foreach ($columns as $column)
            <th scope="col">{{ $column }}</th>
            @endforeach

        </tr>
    </thead>
    <tbody>
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
        </tr>
        @endforeach
        @endif

    </tbody>
</table>