@if($crud->getRouteByMethod('show') && !request()->routeIs($crud->getRouteByMethod('show')))
    <a href="{{ route($crud->getRouteByMethod('show'), $entity) }}" class="btn btn-block btn-outline-info">
        <i class="fa fa-eye"></i>
        {{ trans('laracrud::crud.show') }}
    </a>
@endif
