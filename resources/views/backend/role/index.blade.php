@extends('backend.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    @include('backend.components.table.header_table', [
                        'icon_name'        => 'fa-user-shield',
                        'header_text'      => __('Roles'),
                        'sub_header_title' => __('Manage your roles here'),
                        'btn_title'        => __('Add Role'),
                        'route_create'     => 'role.create',
                    ])
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Created at')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($roles)
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->created_at ? date('d M Y, H:i a', strtotime($role->created_at)) : '' }}
                                            </td>
                                            <td>
                                                @include('backend.components.table.action_btn', [
                                                    'route_delete' => 'role.destroy',
                                                    'row'          => $role,
                                                    'route_edit'   => 'role.edit',
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if (count($roles) != 0)
                        @include('backend.components.table.paginate', ['items' => $roles])
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
