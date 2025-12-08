@include('pages.users._form', [
    'route' => route('admin.users.store'),
    'label' => __('admin.Add'),
    'user' => $user,
])

