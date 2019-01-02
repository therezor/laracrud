@if($crud->getEntityActions())
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                @foreach($crud->getEntityActions() as $action)
                    @include($action)
                @endforeach
            </div>
        </div>
    </div>
@endif
