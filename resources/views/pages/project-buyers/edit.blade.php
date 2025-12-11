@include('pages.project-buyers._form', [
    'route' => '#',
    'method' => 'PUT',
    'label' => __('admin.Edit'),
    'back_route' => route('admin.project-buyers.index'),
])