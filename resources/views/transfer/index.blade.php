@extends('layouts.layout')

@section('content')
<h2>Quản lý giao dịch chuyển kho</h2>
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
                <form action="{{ route('transfer.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="from_warehouse" class="form-label">Kho hàng chuyển đi</label>
                            <select name="from_warehouse" id="from_warehouse" class="form-select">
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="to_warehouse" class="form-label">Kho hàng chuyển đến</label>
                            <select name="to_warehouse" id="to_warehouse" class="form-select">
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
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

        @session('error')
                <div class="alert alert-danger" role="alert"> {{ $value }} </div>
        @endsession
    
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <td>Mã giao dịch</td>
                    <td>Kho hàng chuyển đi</td>
                    <td>Kho hàng chuyển đến</td>
                    <td>Ngày giao dịch</td>
                    <td>Chức năng</td>
                </tr>
            </thead>
            <tbody>
                @foreach($transfers as $transfer)
                    <tr>
                        <td>{{ $transfer->id }}</td>
                        <td>{{ $transfer->fromRel->name }}</td>
                        <td>{{ $transfer->toRel->name }}</td>
                        <td>{{ $transfer->date }}</td>
                        <td class="d-flex justify-content-start gap-2">
                            <form action="{{ route('transfer.show', $transfer->id) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye-fill"></i> Xem
                                </button>
                            </form>

                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$transfer->id}}">
                                <i class="bi bi-trash"></i> Xóa
                            </button>

                            <div class="modal fade" id="deleteModal{{$transfer->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$transfer->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa giao dịch <strong>{{ $transfer->id }}</strong> không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('transfer.destroy', $transfer->id) }}" method="POST" class="d-inline">
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
        
        {!! $transfers->links() !!}
    </div>
</div>  
@endsection