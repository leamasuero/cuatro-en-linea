@extends('layouts.public')

<style>
    td,th {
        border: 1px black solid;
        width: 80px;
        height: 80px;
        text-align: center;
    }
</style>



@section('content')
<h1>Welcome Player {{ $player }}</h1>

<table>
    <thead>
        
        <th>
            <button class="column 0" data-column='0'>Add</button>
        </th>
        <th>
            <button class="column 1" data-column='1'>Add</button>
        </th>
        <th>
            <button class="column 2" data-column='2'>Add</button>
        </th>
        <th>
            <button class="column 3" data-column='3'>Add</button>
        </th>
        <th>
            <button class="column 4" data-column='4'>Add</button>
        </th>
        <th>
            <button class="column 5" data-column='5'>Add</button>
        </th>
        <th>
            <button class="column 6" data-column='6'>Add</button>
        </th>
    
</thead>
<tbody>
    
    @foreach($board as $rowIndex => $row)
    <tr>
        @foreach($row as $columnIndex => $value)
        <td class="row-{{ $rowIndex }} column-{{ $columnIndex }}">
            <div>{{ $value }}</div>
        </td>
        @endforeach

    </tr>
    @endforeach
</tbody>

</table>

@stop('content')