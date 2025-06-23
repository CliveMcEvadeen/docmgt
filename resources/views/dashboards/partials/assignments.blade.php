<section class="mb-4">
    <h2 class="mb-3">Assign Officers to Locations</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.assign_officer') }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="officer" class="form-label">Select Officer</label>
                    <select id="officer" name="officer_id" class="form-select" required>
                        <option value="">-- Select Officer --</option>
                        @foreach($officers as $officer)
                        <option value="{{ $officer->id }}">{{ $officer->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Select Location</label>
                    <select id="location" name="location_id" class="form-select" required>
                        <option value="">-- Select Location --</option>
                        @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Assign Officer</button>
            </form>
            <h3 class="mb-3">Current Officer Assignments</h3>
            <table id="assignmentsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Officer Name</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->officer->full_name }}</td>
                        <td>{{ $assignment->location->name }}</td>
                        <td>
                            <form action="{{ route('admin.remove_assignment', $assignment->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remove this assignment?')">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($assignments->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center text-muted">No assignments found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>
