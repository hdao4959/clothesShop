@extends('admin.layout')

@section('title')
    Chi tiết tài khoản
@endsection

@section('content')
    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif
    <br>
    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h4>Chi tiết tài khoản</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Tên</th>
                    <td>{{ $account->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $account->email }}</td>
                </tr>

                <tr>
                    <th>Ngày tạo</th>
                    <td>{{ $account->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Ngày cập nhật</th>
                    <td>{{ $account->updated_at->format('d/m/Y H:i') }}</td>
                </tr>


            </table>

          
                <form action="{{ route('admin.account.update', $account->id) }}" method="post">
                    @csrf
                    @method("PATCH")
              
                <label for="" class="form-label">Vai trò</label>
                <select @disabled(Auth::check() && Auth::user()->id == $account->id) name="type" id="" class="form-control">
                   <option value="admin" {{ $account->type == 'admin' ? 'selected' : "" }}>Admin</option>
                   <option value="member" {{ $account->type == 'member' ? 'selected' : "" }}>Member</option>
                </select>
                <label for="" class="form-label">Active</label>
                <select @disabled(Auth::check() && Auth::user()->id == $account->id) name="is_active" id="" class="form-control">
                   <option value="1" {{ $account->is_active == 1 ? 'selected' : "" }}>Active</option>
                   <option value="0" {{ $account->is_active == 0 ? 'selected' : "" }}>Not Active</option>
                </select>
            
          
        </div>
        <div class="card-footer text-right">
            <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">Trở về</a>
            <button type="submit" class="btn btn-warning">Sửa</button>
        </div>
    </form>
    </div>
@endsection
