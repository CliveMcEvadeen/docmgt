<div>
    <div class="mb-4">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Search documents..." class="border rounded px-3 py-2 w-full" />
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="upload" enctype="multipart/form-data" class="mb-6 bg-white p-4 rounded shadow">
        <div class="mb-4">
            <label for="title" class="block font-semibold mb-1">Document Title</label>
            <input type="text" id="title" wire:model.defer="title" class="w-full border border-gray-300 rounded px-3 py-2" />
            @error('title') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="file" class="block font-semibold mb-1">Upload File</label>
            <input type="file" id="file" wire:model="file" class="w-full" />
            @error('file') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Upload Document</button>
    </form>

    <table class="min-w-full table-auto border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2 text-left">Title</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Uploaded By</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Uploaded At</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $document)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $document->title }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $document->uploader->full_name ?? 'N/A' }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $document->created_at->format('Y-m-d') }}</td>
                <td class="border border-gray-300 px-4 py-2">
                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-blue-600 hover:underline mr-2">View</a>
                    <button wire:click="delete({{ $document->id }})" class="text-red-600 hover:underline" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                </td>
            </tr>
            @endforeach
            @if($documents->isEmpty())
            <tr>
                <td colspan="4" class="border border-gray-300 px-4 py-2 text-center text-gray-500">No documents found.</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="mt-4">
        {{ $documents->links() }}
    </div>
</div>
