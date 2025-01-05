@extends('layouts.layout')

@section('content')
<a href="{{route('export.index')}}" class="btn btn-primary">Trở về</a>
<h2 class="mt-2">Thông tin giao dịch {{$export->id}}</h2>
<div class="card mt-3">
    <div class="card-body">
        <div class="form-group">
            <label for="customer" class="form-label">Khách hàng</label>
            <input type="text"class="form-control" value="{{ DB::table('customers')->where('id',$export->customer)->first()->name }}" readonly>
        </div>
        <div class="form-group">
            <label for="date" class="form-label">Ngày giao dịch</label>
            <input type="date" class="form-control" value="{{$export->date}}" readonly>
        </div>
        <div class="form-group">
            <label for="warehouse" class="form-label">Kho xuất hàng</label>
            <input type="text" class="form-control" value="{{ DB::table('warehouses')->where('id',$export->warehouse)->first()->name }}" readonly>
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
                @foreach($exportDetails as $exportDetail)
                    <tr>
                        <td>{{ DB::table('items')->where('id',$exportDetail->item)->first()->name }}</td>
                        <td>{{ $exportDetail->quantity }}</td>
                        <td>{{ DB::table('items')->where('id',$exportDetail->item)->first()->unit }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection