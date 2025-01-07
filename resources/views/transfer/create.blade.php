@extends('layouts.layout')

@section('content')
<h2>Thêm giao dịch chuyển kho {{ $transfer }}</h2>
<div class="card mt-5">
    <div class="card-header d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="button" class="btn btn-success btn-sm" id="addRow">
            <i class="bi bi-plus"></i> Thêm
        </button>
    </div>

    <div class="card-body">
        <form action="{{ route('transfer.stockstore')}}" method="POST" id="stockForm">
            @csrf
            <input type="hidden"  name="transfer" value="{{$transfer}}" required>
            <table class="table table-bordered table-striped mt-4" id="dataTable">
                <thead>
                    <tr>
                        <td><label for="item" class="form-label">Sản phẩm</label></td>
                        <td><label for="quantity" class="form-label">Số lượng</label></td>
                        <td>Thao tác</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="form-group">
                            <select name="item[]" class="form-select">
                                @foreach($stocks as $stock)
                                    <option value="{{ $stock->item }}">{{ DB::table('items')->where('id',$stock->item)->first()->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="quantity[]" min="0" required>
                        </td>
                        <td class="d-flex justify-content-start gap-2">
                            <button type="button" class="btn btn-danger btn-sm removeRow">
                                <i class="bi bi-trash"></i> Xóa
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-5 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu</button>   
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('addRow').addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="form-group">
                <select name="item[]" class="form-select">
                    @foreach($stocks as $stock)
                        <option value="{{ $stock->item }}">{{ DB::table('items')->where('id',$stock->item)->first()->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" class="form-control" name="quantity[]" min="0" required>
            </td>
            <td class="d-flex justify-content-start gap-2">
                <button type="button" class="btn btn-danger btn-sm removeRow">
                    <i class="bi bi-trash"></i> Xóa
                </button>
            </td>
        `;
        document.querySelector('#dataTable tbody').appendChild(newRow);
    });

    document.querySelector('#dataTable').addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection