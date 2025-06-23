<div>
    <h2 class="mb-4">Location Management</h2>

    <button wire:click="showCreateModal" class="btn btn-primary mb-3">Add New Location</button>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($locations as $location)
            <tr>
                <td>{{ $location->name }}</td>
                <td>{{ $location->address }}</td>
                <td>
                    <button wire:click="editLocation({{ $location->id }})" class="btn btn-sm btn-warning">Edit</button>
                    <button wire:click="deleteLocation({{ $location->id }})" class="btn btn-sm btn-danger" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($showModal)
    <div class="modal fade show d-block" tabindex="-1" role="dialog" aria-modal="true" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="{{ $editLocationId ? 'updateLocation' : 'createLocation' }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editLocationId ? 'Edit Location' : 'Add New Location' }}</h5>
                        <button type="button" class="btn-close" wire:click="$set('showModal', false)" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input wire:model.defer="name" type="text" class="form-control" id="name" required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea wire:model.defer="address" class="form-control" id="address" rows="3" required></textarea>
                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">Cancel</button>
                        <button type="submit" class="btn btn-primary">{{ $editLocationId ? 'Update' : 'Create' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
