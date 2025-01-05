@extends('layouts.layout')

@section('content')
<h2>Quản lý giao dịch xuất kho</h2>
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
                <form action="{{ route('export.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="customer" class="form-label">Khách hàng</label>
                            <select name="customer" id="customer" class="form-select">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
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
                            <label for="warehouse" class="form-label">Kho xuất hàng</label>
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

        @session('error')
                <div class="alert alert-danger" role="alert"> {{ $value }} </div>
        @endsession
    
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <td>Mã giao dịch</td>
                    <td>Khách hàng</td>
                    <td>Ngày giao dịch</td>
                    <td>Kho xuất hàng</td>
                    <td>Chức năng</td>
                </tr>
            </thead>
            <tbody>
                @foreach($exports as $export)
                    <tr>
                        <td>{{ $export->id }}</td>
                        <td>{{ $export->customerRel->name }}</td>
                        <td>{{ $export->date }}</td>
                        <td>{{ $export->warehouseRel->name }}</td>
                        <td class="d-flex justify-content-start gap-2">
                            <form action="{{ route('export.show', $export->id) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye-fill"></i> Xem
                                </button>
                            </form>

                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$export->id}}">
                                <i class="bi bi-trash"></i> Xóa
                            </button>

                            <div class="modal fade" id="deleteModal{{$export->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$export->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa giao dịch <strong>{{ $export->id }}</strong> không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('export.destroy', $export->id) }}" method="POST" class="d-inline">
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
        
        {!! $exports->links() !!}
    </div>
</div>  
@endsection