<section class="mb-4">
    <h2 class="mb-3">Officers</h2>
    <div class="card">
        <div class="card-body">
            <table id="officersTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($officers as $officer)
                    <tr>
                        <td>{{ $officer->full_name }}</td>
                        <td>{{ $officer->email }}</td>
                        <td>{{ optional(optional($officer->assignment)->location)->name ?? '-' }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    @endforeach
                    @if($officers->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-muted">No officers available.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>
