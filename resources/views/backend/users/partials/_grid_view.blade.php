<div class="grid-view d-none">
    <div class="row g-3">
        @forelse ($users as $row)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="user-card card h-100 border-0 shadow-sm hover-shadow transition-all">
                    <div class="card-body p-3">
                        <div class="text-center mb-3">
                            <div class="user-image mb-2 mx-auto">
                                @if($row->image)
                                    <img src="{{ asset('uploads/all_photo/' . $row->image) }}" alt="{{ $row->name }}" class="img-fluid rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="user-avatar rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" style="width: 80px; height: 80px; font-size: 2rem;">
                                        {{ strtoupper(substr($row->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <h5 class="card-title mb-0">{{ $row->name }}</h5>
                            <span class="badge bg-info text-white my-2">{{ optional($row->roles->first())->name }}</span>
                        </div>
                        <ul class="list-group list-group-flush border-top pt-2">
                            <li class="list-group-item border-0 px-0 py-1">
                                <i class="fas fa-phone-alt text-muted me-2"></i> {{ $row->phone }}
                            </li>
                            <li class="list-group-item border-0 px-0 py-1">
                                <i class="fas fa-envelope text-muted me-2"></i> {{ $row->email }}
                            </li>
                            <li class="list-group-item border-0 px-0 py-1">
                                <i class="fas fa-hashtag text-muted me-2"></i> {{ $loop->iteration }}
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent border-top d-flex justify-content-center gap-2 py-2">
                        @include('backend.components.table.action_btn', [
                            'route_delete' => 'user.destroy',
                            'row'          => $row,
                            'route_edit'   => 'user.edit',
                        ])
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning rounded-pill">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ __('No users found') }}
                </div>
            </div>
        @endforelse
    </div>
</div>