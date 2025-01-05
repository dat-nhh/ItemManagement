@extends('layouts.layout')

@section('content')
<h2>Quản lý kho hàng</h2>
<div class="card mt-5">
    <div class="card-header d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="bi bi-plus"></i> Thêm
        </button>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm kho hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('warehouse.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="form-label">Tên kho</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên kho" required>
                        </div>
                        <div class="form-group">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ kho" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="card-body">
            
            @session('success')
                <div class="alert alert-success" role="alert"> {{ $value }} </div>
            @endsession
    
    
            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        <td>Mã kho hàng</td>
                        <td>Tên kho hàng</td>
                        <td>Địa chỉ</td>
                        <td>Chức năng</td>
                    </tr>
                </thead>
    
                <tbody>
                @foreach($warehouses as $warehouse)
                    <tr>
                        <td>{{$warehouse->id}}</td>
                        <td>{{$warehouse->name}}</td>
                        <td>{{$warehouse->address}}</td>
                        <td class="d-flex justify-content-start gap-2">
                            <form action="{{ route('warehouse.show', $warehouse->id) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye-fill"></i> Xem
                                </button>
                            </form>
                            
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$warehouse->id}}">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </button>

                            <div class="modal fade" id="editModal{{$warehouse->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Chỉnh sửa kho</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('warehouse.update', $warehouse->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="name">Tên kho</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $warehouse->name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address">Địa chỉ</label>
                                                    <input type="text" class="form-control" id="address" name="address" value="{{ $warehouse->address }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$warehouse->id}}">
                                <i class="bi bi-trash"></i> Xóa
                            </button>

                            <div class="modal fade" id="deleteModal{{$warehouse->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$warehouse->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{$warehouse->id}}">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa kho <strong>{{ $warehouse->name }}</strong> không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('warehouse.destroy', $warehouse->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>
                @endforeach
                </tbody>
    
            </table>
            
            {!! $warehouses->links() !!}

    </div>
</div>  
@endsection


