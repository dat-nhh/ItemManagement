@extends('layouts.layout')

@section('content')
<h2>Nhà cung cấp</h2>
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
                    <h5 class="modal-title" id="addModalLabel">Thêm nhà cung cấp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('vendor.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="form-label">Tên nhà cung cấp</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên nhà cung cấp" required>
                        </div>
                        <div class="form-group">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ" required>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Nhập email" required>
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
                        <td>Mã nhà cung cấp</td>
                        <td>Tên nhà cung cấp</td>
                        <td>Địa chỉ</td>
                        <td>Số điện thoại</td>
                        <td>Email</td>
                        <td>Chức năng</td>
                    </tr>
                </thead>
    
                <tbody>
                @foreach($vendors as $vendor)
                    <tr>
                        <td>{{$vendor->id}}</td>
                        <td>{{$vendor->name}}</td>
                        <td>{{$vendor->address}}</td>
                        <td>{{$vendor->phone}}</td>
                        <td>{{$vendor->email}}</td>
                        <td class="d-flex justify-content-start gap-2">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$vendor->id}}">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </button>

                            <div class="modal fade" id="editModal{{$vendor->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Chỉnh sửa nhà cung cấp</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('vendor.update', $vendor->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="name">Tên nhà cung cấp</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $vendor->name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address" class="form-label">Địa chỉ</label>
                                                    <input type="text" class="form-control" id="address" name="address" value="{{$vendor->address}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone" class="form-label">Số điện thoại</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="{{$vendor->phone}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="text" class="form-control" id="email" name="email" value="{{$vendor->email}}" required>
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

                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$vendor->id}}">
                                <i class="bi bi-trash"></i> Xóa
                            </button>

                            <div class="modal fade" id="deleteModal{{$vendor->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$vendor->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{$vendor->id}}">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa nhà cung cấp <strong>{{ $vendor->name }}</strong> không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('vendor.destroy', $vendor->id) }}" method="POST" class="d-inline">
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
            
            {!! $vendors->links() !!}

    </div>
</div>  


@endsection