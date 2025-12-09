@include('pages.investors._form', [
    'route' => route('admin.investors.store'),
    'label' => __('admin.Update'),
    'user' => $investor,
])

