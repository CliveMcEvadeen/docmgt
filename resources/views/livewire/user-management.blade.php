<div>
    <div class="mb-4">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Search admins..." class="border rounded px-3 py-2 w-full" />
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <table class="min-w-full table-auto border-collapse border border-gray-200 mb-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Mobile No</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $user->full_name }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $user->mobile_no }}</td>
                <td class="border border-gray-300 px-4 py-2">
                    <button wire:click="editUser({{ $user->id }})" class="text-blue-600 hover:underline mr-2">Edit</button>
                    <button wire:click="deleteUser({{ $user->id }})" class="text-red-600 hover:underline" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                </td>
            </tr>
            @endforeach
            @if($users->isEmpty())
            <tr>
                <td colspan="4" class="border border-gray-300 px-4 py-2 text-center text-gray-500">No admin users found.</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div>
        {{ $users->links() }}
    </div>

    <div class="mt-6">
        <h2 class="text-xl font-semibold mb-4">{{ $editUserId ? 'Edit Admin User' : 'Create Admin User' }}</h2>
        <form wire:submit.prevent="{{ $editUserId ? 'updateUser' : 'createUser' }}">
            <div class="mb-4">
                <label for="firstname" class="block font-semibold mb-1">First Name</label>
                <input type="text" id="firstname" wire:model.defer="firstname" class="w-full border border-gray-300 rounded px-3 py-2" />
                @error('firstname') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="lastname" class="block font-semibold mb-1">Last Name</label>
                <input type="text" id="lastname" wire:model.defer="lastname" class="w-full border border-gray-300 rounded px-3 py-2" />
                @error('lastname') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="email" class="block font-semibold mb-1">Email</label>
                <input type="email" id="email" wire:model.defer="email" class="w-full border border-gray-300 rounded px-3 py-2" />
                @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="mobile_no" class="block font-semibold mb-1">Mobile No</label>
                <input type="text" id="mobile_no" wire:model.defer="mobile_no" class="w-full border border-gray-300 rounded px-3 py-2" />
                @error('mobile_no') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="block font-semibold mb-1">{{ $editUserId ? 'New Password (leave blank to keep current)' : 'Password' }}</label>
                <input type="password" id="password" wire:model.defer="password" class="w-full border border-gray-300 rounded px-3 py-2" />
                @error('password') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block font-semibold mb-1">Confirm Password</label>
                <input type="password" id="password_confirmation" wire:model.defer="password_confirmation" class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                {{ $editUserId ? 'Update User' : 'Create User' }}
            </button>
            @if($editUserId)
            <button type="button" wire:click="resetInputFields" class="ml-2 bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</button>
            @endif
        </form>
    </div>
</div>
