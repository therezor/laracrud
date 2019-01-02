@extends('laracrud::layouts.app')

@section('title', $crud->getCrudName())

@section('header')
    <h1 class="h4">
        {{ $crud->getCrudName() }}

        <small class="text-muted">
            {{ trans('laracrud::crud.show') }}
        </small>
    </h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box">
                <div class="box-body">
                    <ul class="list-group list-group-unbordered">
                        @foreach($fields as $field)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-sm-4 text-muted">
                                        <b>{{ $field->resolveLabel($entity) }}</b>
                                    </div>

                                    <div class="col-sm-8">
                                        {{ $field->render($entity) }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @include('laracrud::crud.includes.actions')
    </div>
@endsection
