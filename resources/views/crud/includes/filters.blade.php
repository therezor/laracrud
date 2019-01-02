<a href="#filters" class="btn btn-sm btn-secondary" data-toggle="collapse" role="button">
    <i class="fa fa-search"></i>
    <b>{{ trans('laracrud::crud.filters') }}</b>
    @if($filterForm->getFieldValues(false))
        <span class="badge badge-pill badge-danger">{{ count($filterForm->getFieldValues(false)) }}</span>
    @endif
</a>
@if($filterForm->getFieldValues(false))
    <a href="{{ url()->current() }}" class="btn btn-sm btn-danger">
        <i class="fa fa-times"></i>
    </a>
@endif

<div id="filters" class="panel-collapse collapse">
    <div class="p-3">
        {!! form_start($filterForm) !!}
        <div class="row">
            {!! form_rest($filterForm) !!}
        </div>

        <button type="submit" class="btn btn-primary">{{ trans('laracrud::crud.filter') }}</button>
        {!! form_end($filterForm) !!}
    </div>
</div>
