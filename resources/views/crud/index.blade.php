@extends('laracrud::layouts.app')

@section('title', $crud->getCrudName())

@section('header')
    {{ $crud->getCrudName() }}

    <small class="text-muted">
        {{ trans('laracrud::crud.list') }}
    </small>
@endsection

@push('actions')
    @if($crud->getRouteByMethod('create'))
        <a href="{{ route($crud->getRouteByMethod('create')) }}" class="btn btn-sm btn-success">
            <i class="fa fa-plus"></i>
            {{ trans('laracrud::crud.create') }}
        </a>
    @endif
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            @if($filterForm)
                @include('laracrud::crud.includes.filters')
            @endif
        </div>

        <div class="card-body p-0">
            <div class="table-responsive-md">
                @include('laracrud::crud.includes.table')
            </div>
        </div>

        <div class="card-footer">
            @if(method_exists($entities, 'links'))
            <div class="row">
                <div class="col-md-4">
                    <ul class="pagination m-0">
                        <li class="page-item disabled">
                            <span class="page-link">{{ trans('laracrud::crud.total') }}: {{ $entities->total() }}</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8">
                    {{ $entities->appends(request()->all())->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection


