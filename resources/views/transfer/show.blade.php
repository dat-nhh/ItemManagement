@extends('layouts.layout')

@section('content')
<a href="{{route('transfer.index')}}" class="btn btn-primary">Trở về</a>
<h2 class="mt-2">Thông tin giao dịch {{$transfer->id}}</h2>
<div class="card mt-3">
    <div class="card-body">
        <div class="form-group">
            <label for="from_warehouse" class="form-label">Kho hàng chuyển đi</label>
            <input type="text" class="form-control" value="{{ DB::table('warehouses')->where('id',$transfer->from_warehouse)->first()->name }}" readonly>
        </div>
        <div class="form-group">
            <label for="to_warehouse" class="form-label">Kho hàng chuyển đến</label>
            <input type="text" class="form-control" value="{{ DB::table('warehouses')->where('id',$transfer->to_warehouse)->first()->name }}" readonly>
        </div>
        <div class="form-group">
            <label for="date" class="form-label">Ngày giao dịch</label>
            <input type="date" class="form-control" value="{{$transfer->date}}" readonly>
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
                @foreach($transferDetails as $transferDetail)
                    <tr>
                        <td>{{ DB::table('items')->where('id',$transferDetail->item)->first()->name }}</td>
                        <td>{{ $transferDetail->quantity }}</td>
                        <td>{{ DB::table('items')->where('id',$transferDetail->item)->first()->unit }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection