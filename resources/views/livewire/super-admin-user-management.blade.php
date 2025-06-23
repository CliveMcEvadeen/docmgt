@extends('layouts.app')

@section('content')
<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <button class="btn btn-primary mb-3" wire:click="showCreateModal">Create Admin</button>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->firstname }} {{ $admin->lastname }}</td>
                <td>{{ $admin->email }}</td>
            </tr>
            @endforeach
            @if($admins->isEmpty())
            <tr>
                <td colspan="2" class="text-center text-muted">No admins available.</td>
            </tr>
            @endif
        </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade @if($showModal) show d-block @endif" tabindex="-1" style="@if($showModal) display:block; background:rgba(0,0,0,0.5); @else display:none; @endif">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Admin</h5>
                    <button type="button" class="btn-close" wire:click="$set('showModal', false)"></button>
                </div>
                <form wire:submit.prevent="createAdmin">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>First Name</label>
                            <input type="text" class="form-control" wire:model.defer="firstname" required>
                        </div>
                        <div class="mb-3">
                            <label>Last Name</label>
                            <input type="text" class="form-control" wire:model.defer="lastname" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" wire:model.defer="email" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="text" class="form-control" wire:model.defer="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
