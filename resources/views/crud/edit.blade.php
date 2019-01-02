@extends('laracrud::layouts.app')

@section('title', $crud->getCrudName())

@section('header')
    {{ $crud->getCrudName() }}

    <small class="text-muted">
        {{ trans('laracrud::crud.edit') }}
    </small>
@endsection

@section('content')
     <div class="row">
         <div class="col-md-8">
            <div class="card">
                @if($form)
                    <div class="card-body">
                        {!! form_start($form) !!}
                        {!! form_rest($form) !!}
                        <button type="submit" class="btn btn-success">{{ trans('laracrud::crud.update') }}</button>
                        <a href="{{ URL::previous() }}" class="btn btn-light">{{ trans('laracrud::crud.cancel') }}</a>
                        {!! form_end($form) !!}
                    </div>
                @endif
            </div>
         </div>
         @include('laracrud::crud.includes.actions')
    </div>
@endsection
