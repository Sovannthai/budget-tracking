<div class="table-view">
    <div class="table-responsive">
        <table class="table text-start table-hover align-middle">
            <thead >
                <tr>
                    <th></th>
                    <th>{{ __('No.') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Phone') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Role') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $row)
                    <tr class="border-bottom hover-shadow transition-all">
                        <td>
                            @include('backend.components.table.show_image_table',[
                                'field_name' => $row->image,
                                'id'         => $row->id,
                                'image_path' => 'uploads/all_photo/',
                            ])
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->name }} </td>
                        <td>{{ $row->phone }}</td>
                        <td>{{ $row->email }}</td>
                        <td><span class="badge bg-info text-white">{{ optional($row->roles->first())->name }}</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                @include('backend.components.table.action_btn', [
                                    'route_delete' => 'user.destroy',
                                    'row'          => $row,
                                    'route_edit'   => 'user.edit',
                                ])
                            </div>
                        </td>
                    </tr>
                @empty
                    @include('backend.components.table.not_found_item', [
                        'total_colspan' => 7,
                        'messages'      => __('No users found'),
                    ])
                @endforelse
            </tbody>
        </table>
    </div>
</div>