<section>
    <h2 class="mb-3">Documents and Files</h2>
    <div class="card">
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @foreach($documents as $document)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('documents.show', $document->id) }}" class="text-decoration-none">{{ $document->title }}</a>
                    <small class="text-muted">Uploaded on {{ $document->created_at->format('M d, Y') }}</small>
                </li>
                @endforeach
                @if($documents->isEmpty())
                <li class="list-group-item text-muted">No documents available.</li>
                @endif
            </ul>
        </div>
    </div>
</section>
<section>
    <h2 class="mb-3">Documents Uploaded by Assigned Officers</h2>
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered" id="officerDocumentsTable">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Officer</th>
                        <th>Uploaded On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                        @if($officers->pluck('id')->contains($document->user_id))
                        <tr>
                            <td>{{ $document->title }}</td>
                            <td>{{ optional($officers->where('id', $document->user_id)->first())->full_name }}</td>
                            <td>{{ $document->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('documents.show', $document->id) }}" class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    @if($documents->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-muted">No documents available.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>
