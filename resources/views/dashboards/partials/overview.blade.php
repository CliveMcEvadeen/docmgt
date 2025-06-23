<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-primary text-dark h-100" style="background-color: white;">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-user-shield fa-3x me-3 text-primary"></i>
                <div>
                    <h5 class="card-title">Total Officers</h5>
                    <p class="card-text fs-4">{{ $officers->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-success text-dark h-100" style="background-color: white;">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-map-marker-alt fa-3x me-3 text-success"></i>
                <div>
                    <h5 class="card-title">Total Locations</h5>
                    <p class="card-text fs-4">{{ $locations->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-warning text-dark h-100" style="background-color: white;">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-tasks fa-3x me-3 text-warning"></i>
                <div>
                    <h5 class="card-title">Assignments</h5>
                    <p class="card-text fs-4">{{ $assignments->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-info text-dark h-100" style="background-color: white;">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-folder-open fa-3x me-3 text-info"></i>
                <div>
                    <h5 class="card-title">Documents</h5>
                    <p class="card-text fs-4">{{ $documents->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
