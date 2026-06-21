@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <h3>Edit User</h3>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
    </form>

</div>
@endsection