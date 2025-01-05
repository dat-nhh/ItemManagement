@extends('layouts.layout')

@section('content')
<h2>Quản lý sản phẩm</h2>
<div class="card mt-5">
    <div class="card-header d-flex justify-content-between">
        <div class="me-auto gap-2 d-md-flex">
            <form action="{{route('item.search')}}" method="GET" onsubmit="this.submit();">
                <input type="text" class="form-control" placeholder="Tìm kiếm..." aria-label="Search" name="search" value="{{ request('search') }}" required>
            </form>
            <a href="{{route('item.index')}}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-counterclockwise"></i>Làm mới</a>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{route('category.index')}}" class="btn btn-success btn-sm">Danh mục</a>
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus"></i> Thêm
            </button>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('item.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <label for="category" class="form-label">Phân loại</label>
                            <select name="category" id="category" class="form-select">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="unit" class="form-label">Đơn vị</label>
                            <input type="text" class="form-control" id="unit" name="unit" placeholder="Nhập đơn vị" required>
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
                        <td>Mã sản phẩm</td>
                        <td>Tên sản phẩm</td>
                        <td>Phân loại</td>
                        <td>Đơn vị</td>
                        <td>Chức năng</td>
                    </tr>
                </thead>
    
                <tbody>
                @if ($results)
                    {{$paginate = $results}}
                    @foreach ($results as $result)
                        <tr>
                            <td>{{$result->id}}</td>
                            <td>{{ $result->name }}</td>
                            <td>{{$result->categoryRel->name}}</td>
                            <td>{{$result->unit}}</td>
                            <td class="d-flex justify-content-start gap-2">
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$result->id}}">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </button>

                                <div class="modal fade" id="editModal{{$result->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Chỉnh sửa sản phẩm</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('item.update', $result->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">Tên sản phẩm</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{$result->name}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="category" class="form-label">Phân loại</label>
                                                        <select name="category" id="category" class="form-select">
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="unit" class="form-label">Đơn vị</label>
                                                        <input type="text" class="form-control" id="unit" name="unit" value="{{$result->unit}}" required>
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

                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$result->id}}">
                                    <i class="bi bi-trash"></i> Xóa
                                </button>

                                <div class="modal fade" id="deleteModal{{$result->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$result->id}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{$result->id}}">Xác nhận xóa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa sản phẩm <strong>{{ $result->name }}</strong> không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <form action="{{ route('item.destroy', $result->id) }}" method="POST" class="d-inline">
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
                @else
                    {{$paginate = $items}}
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->categoryRel->name}}</td>
                            <td>{{$item->unit}}</td>
                            <td class="d-flex justify-content-start gap-2">
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$item->id}}">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </button>

                                <div class="modal fade" id="editModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Chỉnh sửa sản phẩm</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('item.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name" class="form-label">Tên sản phẩm</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="{{$item->name}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="category" class="form-label">Phân loại</label>
                                                        <select name="category" id="category" class="form-select">
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="unit" class="form-label">Đơn vị</label>
                                                        <input type="text" class="form-control" id="unit" name="unit" value="{{$item->unit}}" required>
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

                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$item->id}}">
                                    <i class="bi bi-trash"></i> Xóa
                                </button>

                                <div class="modal fade" id="deleteModal{{$item->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$item->id}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{$item->id}}">Xác nhận xóa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa sản phẩm <strong>{{ $item->name }}</strong> không?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <form action="{{ route('item.destroy', $item->id) }}" method="POST" class="d-inline">
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
                @endif
                </tbody>
    
            </table>
            
            {!! $paginate->links() !!}

    </div>
</div>  
@endsection


