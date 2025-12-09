@include('pages.roles._form', [
    'route' => route('admin.roles.store'),
    'label' => __('admin.Add'),
    'role' => $role,
])

