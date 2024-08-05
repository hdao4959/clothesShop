@extends('admin.layout')
@section('title')
    Danh sách người dùng
@endsection
@section('content')
    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</d>
    @endif <br>
    @if (session('success'))
        <div  class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>Email</th>
                <th>Role</th>
                <th>IS_ACTIVE</th>
                <th>CREATED AT</th>
                <th>UPDATED AT</th>
                <th>ACTION</th>
            </tr>
        </thead>
        

        @foreach ($accounts as $account)
            <tr>
                <td>{{ $account->id }}</td>
                <td>{{ $account->name }}</td>
                <td>{{ $account->email }}</td>
                <td>
                    <span class="badge {{ $account->type == 'admin' ? ' bg-danger' : 'bg-primary' }}">{{ $account->type }}</span>
                </td>
                <td>{!! $account->is_active ? 
                    '<span class="badge bg-success">Yes</span>' : 
                    '<span class="badge bg-danger">No</span>' !!}
                </td>
                <td>{{ $account->created_at }}</td>
                <td>{{ $account->updated_at }}</td>
                <td>
                    <form action="{{ route('admin.account.delete', $account->id) }}" method="post">
                        @csrf
                        <a class="btn btn-sm btn-secondary" href="{{ route('admin.account.show', $account) }}">Detail</a>
                        
                        <button @disabled(Auth::check() && Auth::user()->id == $account->id) onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" type="submit" class="btn btn-sm btn-danger">Delete</button>
         
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $accounts->links('pagination::bootstrap-5') }}
@endsection
