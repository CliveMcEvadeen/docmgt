<section class="mb-4">
    <h2 class="mb-3">Admins</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#registerAdminModal">Register Admin</button>
    <div class="card">
        <div class="card-body">
            <table id="adminsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->full_name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('superadmin.admins.edit', $admin->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('superadmin.admins.destroy', $admin->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($admins->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center text-muted">No admins available.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Register Admin Modal -->
    <div class="modal fade" id="registerAdminModal" tabindex="-1" aria-labelledby="registerAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerAdminModalLabel">Register New Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.admins.store') }}" method="POST">
                    <div class="alert alert-info">Form action: {{ route('superadmin.admins.store') }}</div>
                    @csrf
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <input type="hidden" name="test_submit" value="1">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
