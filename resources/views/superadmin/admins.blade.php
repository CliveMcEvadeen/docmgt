@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <h1 class="mb-4">Admin Management</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @include('superadmin.partials.admins', ['admins' => $admins])
</div>
@endsection
