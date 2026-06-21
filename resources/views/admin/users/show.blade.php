@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <h3>User Details</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Created:</strong> {{ $user->created_at }}</p>
            <p><strong>Updated:</strong> {{ $user->updated_at }}</p>

            <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>

</div>
@endsection