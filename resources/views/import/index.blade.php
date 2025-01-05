@extends('layouts.layout')

@section('content')
<h2>Quản lý giao dịch nhậpk kho</h2>
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
                    <h5 class="modal-title" id="addModalLabel">Thêm giao dịch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('import.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="vendor" class="form-label">Nhà cung cấp</label>
                            <select name="vendor" id="vendor" class="form-select">
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date" class="form-label">Ngày giao dịch</label>
                            <input type="date" class="form-control set-today" id="date" name="date" required>
                            <script type="text/javascript">
                                window.onload= function() {
                                    document.querySelector('.set-today').value=(new Date()).toISOString().substr(0,10);
                                }
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="warehouse" class="form-label">Kho nhập hàng</label>
                            <select name="warehouse" id="warehouse" class="form-select">
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
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
        @if(session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
    
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <td>Mã giao dịch</td>
                    <td>Nhà cung cấp</td>
                    <td>Ngày giao dịch</td>
                    <td>Kho nhập hàng</td>
                    <td>Chức năng</td>
                </tr>
            </thead>
            <tbody>
                @foreach($imports as $import)
                    <tr>
                        <td>{{ $import->id }}</td>
                        <td>{{ $import->vendorRel->name }}</td>
                        <td>{{ $import->date }}</td>
                        <td>{{ $import->warehouseRel->name }}</td>
                        <td class="d-flex justify-content-start gap-2">
                            <form action="{{ route('import.show', $import->id) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye-fill"></i> Xem
                                </button>
                            </form>

                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$import->id}}">
                                <i class="bi bi-trash"></i> Xóa
                            </button>

                            <div class="modal fade" id="deleteModal{{$import->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$import->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa giao dịch <strong>{{ $import->id }}</strong> không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('import.destroy', $import->id) }}" method="POST" class="d-inline">
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
        
        {!! $imports->links() !!}
    </div>
</div>  
@endsection