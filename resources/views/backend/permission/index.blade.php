@extends('backend.layouts.app')
@section('title', __('Permission'))
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    @include('backend.components.table.header_table', [
                        'icon_name'        => 'fa-user-shield',
                        'header_text'      => __('Permissions'),
                        'sub_header_title' => __('Manage your permissions here'),
                        'btn_title'        => __('Add Permission'),
                    ])
                    <a href="#" class="btn btn-primary float-end text-capitalize" data-bs-toggle="modal"
                        data-bs-target="#create_permission">
                        <i class="fa fa-plus-circle"></i> @lang('Add New')</a>
                    @include('backend.permission.create')
                </div>
                <div class="card-body table-wrapper">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-hover">
                            <thead>
                                <tr>
                                    <th>@lang('No.')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Guard')</th>
                                    <th>@lang('Created at')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
    
                            <body>
                                @if ($permissions)
                                    @forelse ($permissions as $permission)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                            <td>{{ $permission->created_at ? date('d M Y, H:i a', strtotime($permission->created_at)) : '' }}
                                            </td>
                                            <td>
                                                <a href="#" class="me-2" data-bs-toggle="modal"
                                                    data-bs-target="#editPermissionModal-{{ $permission->id }}"
                                                    title="@lang('Edit')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                        viewBox="0 0 24 24">
                                                        <path fill="#305cff"
                                                            d="M20.22 2H7.78C6.8 2 6 2.8 6 3.78v12.44C6 17.2 6.8 18 7.78 18h12.44c.98 0 1.78-.79 1.78-1.78V3.78C22 2.8 21.2 2 20.22 2m-9.16 13H9v-2.06l6.06-6.06l2.06 2.06zm7.64-7.65l-1 1l-2.05-2.05l1-1c.21-.22.56-.22.77 0l1.28 1.28c.22.21.22.56 0 .77M4 6H2v14a2 2 0 0 0 2 2h14v-2H4z"
                                                            stroke-width="0.5" stroke="" />
                                                    </svg>
                                                </a>
                                                @include('backend.components.table.action_btn', [
                                                    'route_delete' => 'permission.destroy',
                                                    'row'          => $permission,
                                                ])
                                            </td>
                                        </tr>
                                        @include('backend.permission.edit')
                                    @empty
                                        @include('backend.components.table.not_found_item', [
                                            'total_colspan' => 5,
                                            'messages'      => __('No permissions found'),
                                        ])
                                    @endforelse
                                @endif
                            </body>
                        </table>
                    </div>
                    @if (count($permissions) != 0)
                        @include('backend.components.table.paginate', ['items' => $permissions])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
