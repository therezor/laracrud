@if($crud->getRouteByMethod('destroy'))
    <a href="{{ route($crud->getRouteByMethod('destroy'), $entity) }}" data-method="delete" data-confirm-message="{{ trans('laracrud::crud.confirmation') }}" class="btn btn-block btn-outline-danger">
        <i class="fa fa-trash"></i>
        {{ trans('laracrud::crud.destroy') }}
    </a>
@endif
