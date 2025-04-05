<span>
    <a class="example-image-link"
        href="{{ $field_name ? asset($image_path . $field_name) : asset('uploads/images/defualt.png') }}"
        data-lightbox="lightbox-{{ $id }}">
        <img class="avatar rounded-circle"
            src="{{ $field_name ? asset($image_path . $field_name) : asset('uploads/images/defualt.png') }}"
            alt="profile" width="50px" height="50px" style="cursor:pointer" />
    </a>
</span>
