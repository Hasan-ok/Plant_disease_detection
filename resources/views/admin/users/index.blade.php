@extends('layouts.admin')

@section('title', 'Manage Users')
@section('page-title', 'Users')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.users.create') }}" class="btn btn-success">Add New User</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th><th>Email</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td><td>{{ $user->email }}</td>
            <td>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
@endsection

