@include('pages.project-investors._form', [
    'route' => '#', 
    'method' => 'POST',
    'label' => __('admin.Add'),
    'back_route' => route('admin.project-investors.index'),
])
    