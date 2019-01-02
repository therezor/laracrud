@if($field->hasAction('show') && Route::has($field->getRoutePrefix() . '.show'))
    <a href="{{ route($field->getRoutePrefix() . '.show', $value) }}" data-toggle="tooltip" data-placement="top"
       title="{{ trans('laracrud::crud.show') }}" class="btn btn-sm btn-info">
        <i class="fa fa-eye"></i>
    </a>
@endif

@if($field->hasAction('show') && Route::has($field->getRoutePrefix() . '.edit'))
    <a href="{{ route($field->getRoutePrefix() . '.edit', $value) }}" data-toggle="tooltip" data-placement="top"
       title="{{ trans('laracrud::crud.update') }}" class="btn btn-sm btn-warning">
        <i class="fa fa-pencil"></i>
    </a>
@endif

@if($field->hasAction('destroy') && Route::has($field->getRoutePrefix() . '.destroy'))
    <a href="{{ route($field->getRoutePrefix() . '.destroy', $value) }}" data-confirm-message="{{ trans('laracrud::crud.confirmation') }}" data-toggle="tooltip" data-placement="top"
       title="{{ trans('laracrud::crud.destroy') }}" data-method="delete" class="btn btn-sm btn-danger">
        <i class="fa fa-trash"></i>
    </a>
@endif
