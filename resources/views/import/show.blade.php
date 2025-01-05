@extends('layouts.layout')

@section('content')
<a href="{{route('import.index')}}" class="btn btn-primary">Trở về</a>
<h2 class="mt-2">Thông tin giao dịch {{$import->id}}</h2>
<div class="card mt-3">
    <div class="card-body">
        <div class="form-group">
            <label for="vendor" class="form-label">Nhà cung cấp</label>
            <input type="text"class="form-control" value="{{ DB::table('vendors')->where('id',$import->vendor)->first()->name }}" readonly>
        </div>
        <div class="form-group">
            <label for="date" class="form-label">Ngày giao dịch</label>
            <input type="date" class="form-control" value="{{$import->date}}" readonly>
        </div>
        <div class="form-group">
            <label for="warehouse" class="form-label">Kho nhập hàng</label>
            <input type="text" class="form-control" value="{{ DB::table('warehouses')->where('id',$import->warehouse)->first()->name }}" readonly>
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
                @foreach($importDetails as $importDetail)
                    <tr>
                        <td>{{ DB::table('items')->where('id',$importDetail->item)->first()->name }}</td>
                        <td>{{ $importDetail->quantity }}</td>
                        <td>{{ DB::table('items')->where('id',$importDetail->item)->first()->unit }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection