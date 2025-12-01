@include('pages.project-investors._form', [
    'route' => '#',
    'method' => 'PUT',
    'label' => __('admin.Edit'),
    'back_route' => route('admin.investors.index'),
])
