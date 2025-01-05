@extends('layouts.layout')

@section('content')
<a href="{{route('warehouse.index')}}" class="btn btn-primary">Trở về</a>
<h2 class="mt-2">Thông tin kho hàng {{$warehouse->id}} </h2>
<div class="card mt-3">
    <div class="card-body">
        <div class="form-group">
            <label for="name" class="form-label">Tên kho hàng</label>
            <input type="text"class="form-control" value="{{$warehouse->name}}" readonly>
        </div>
        <div class="form-group">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" value="{{$warehouse->address}}">
        </div>
    </div>
</div>

<div class="card mt-2">
    <div class="card-body">
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <td>Sản phẩm</td>
                    <td>Số lượng</td>
                    <td>Đơn vị</td>
                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $stock)
                    <tr>
                        <td>{{ DB::table('items')->where('id',$stock->item)->first()->name }}</td>
                        <td>{{ $stock->quantity }}</td>
                        <td>{{ DB::table('items')->where('id',$stock->item)->first()->unit }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection