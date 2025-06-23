@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Admin</h2>
    <form action="{{ route('superadmin.admins.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $admin->full_name) }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password <small>(leave blank to keep current)</small></label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('superadmin.admins') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
