@extends('index')

@section('content')

    <h2>Ваши заказы</h2>

    <table class="table">
        <thead>
        <tr>
            <th>Товар</th>
            <th>Цена от</th>
            <th>Цена до</th>
            <th>Количество</th>
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
                <td>{{ $item->count }}</td>
                <td>{{ $item->state=='used'?'б/у':'новый' }}</td>
            </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOrderModal">Добавить новый заказ</button>

    <div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOrderModalLabel">Новый заказ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/orders/add') }}" method="post" id="addOrderForm">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label">Название товара</label>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Цена от</label>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Цена до</label>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Количество</label>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Б/У</label>
                            </div>
                        </div>
                        <div class="row goodsRow">
                            <div class="col-4 mb-3">
                                <select name="orderGood[]" class="form-select">
                                    @foreach($allGoods as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2 mb-3">
                                <input type="number" id="orderPriceMin" class="form-control" name="orderPriceMin[]">
                            </div>
                            <div class="col-2 mb-3">
                                <input type="number" id="orderPriceMax" class="form-control" name="orderPriceMax[]">
                            </div>
                            <div class="col-2 mb-3">
                                <input type="number" id="orderCount" class="form-control" name="orderCount[]">
                            </div>
                            <div class="col-2 form-check">
                                <select name="orderUsed[]" class="form-select">
                                    <option value="new">Новый</option>
                                    <option value="used">Б/У</option>
                                </select>
                            </div>
                        </div>
                        <div class="row"><div class="col text-end"><button type="button" id="addRow" class="btn btn-info">Добавить</button></div></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <input type="submit" class="btn btn-primary" form="addOrderForm" value="Добавить">
                </div>
            </div>
        </div>
    </div>

<script>
    $('document').ready(function(){
        $('#addRow').click(function(){
            $(this).parent().parent().before($('.goodsRow').first().clone());
        });
    });
</script>

@endsection
