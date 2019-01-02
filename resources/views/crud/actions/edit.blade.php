@if($crud->getRouteByMethod('edit') && !request()->routeIs($crud->getRouteByMethod('edit')))
    <a href="{{ route($crud->getRouteByMethod('edit'), $entity) }}" class="btn btn-block btn-outline-warning">
        <i class="fa fa-pencil"></i>
        {{ trans('laracrud::crud.edit') }}
    </a>
@endif
