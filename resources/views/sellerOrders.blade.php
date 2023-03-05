@extends('index')

@section('content')

    <h2>Подходящие заказы</h2>

    <table class="table">
        <thead>
        <tr>
            <th>Товар</th>
            <th>Цена от</th>
            <th>Цена до</th>
            <th>Количество (в наличии)</th>
            <th>Б/У</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $key => $items)
            <tr>
                <td colspan="5"><h3>Заказ #{{ $key }}</h3></td>
            </tr>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->priceMin }}</td>
                    <td>{{ $item->priceMax }}</td>
                    <td>{{ $item->count }} ({{ $item->have }})</td>
                    <td>{{ $item->state=='used'?'б/у':'новый' }}</td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
@endsection
