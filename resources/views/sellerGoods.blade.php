@extends('index')

@section('content')

    <h2>Ваши товары</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Б/У</th>
            </tr>
        </thead>
        <tbody>
        @foreach($goods as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->count }}</td>
                <td>{{ $item->state=='used'?'б/у':'новый' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGoodsModsl">Добавить новый товар</button>

    <div class="modal fade" id="addGoodsModsl" tabindex="-1" aria-labelledby="addGoodsModslLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGoodsModslLabel">Добавить товар</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/goods/add') }}" method="post" id="addGoodsForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="goodsTitle">Название товара</label>
                            <input type="text" id="goodsTitle" class="form-control" name="goodsTitle" list="goodsList">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="goodsPrice">Цена товара</label>
                            <input type="number" id="goodsPrice" class="form-control" name="goodsPrice" value="100">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="goodsCount">Количество товара</label>
                            <input type="number" id="goodsCount" class="form-control" name="goodsCount" value="0">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="goodsUsed" name="goodsUsed">
                            <label class="form-check-label" for="goodsUsed">Б/У</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <input type="submit" class="btn btn-primary" form="addGoodsForm" value="Добавить">
                </div>
            </div>
        </div>
    </div>

    <datalist id="goodsList">
        @foreach($allGoods as $item)
            <option value="{{ $item->title }}">
        @endforeach
    </datalist>



@endsection
