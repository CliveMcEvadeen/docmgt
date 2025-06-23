<section class="mb-4">
    <h2 class="mb-3">Documents</h2>
    <div class="card">
        <div class="card-body">
            <table id="documentsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Uploaded On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                    <tr>
                        <td>{{ $document->title }}</td>
                        <td>{{ $document->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('documents.show', $document->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    @endforeach
                    @if($documents->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center text-muted">No documents available.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>
