<table class="table table-striped m-0">
    <thead>
    <tr>
        @foreach($fields as $field)
            <th class="{{ $field->getMeta('list.class') }}">
                {{ $field->resolveLabel($emptyEntity) }}
                @if($field->isSortable())
                    <a href="{{ $field->sortableUrl(request()) }}">
                        @if($field->getSortDirection())
                            <i class="fa fa-sort-{{ $field->getSortDirection() }}"></i>
                        @else
                            <i class="fa fa-sort"></i>
                        @endif
                    </a>
                @endif
            </th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @forelse($entities as $entity)
        <tr>
            @foreach($fields as $field)
                <td class="{{ $field->getMeta('list.class') }}">
                    {{ $field->render($entity) }}
                </td>
            @endforeach
        </tr>
    @empty
        <tr>
            <td colspan="{{ count($fields) }}" class="text-center"><i>{{ trans('laracrud::crud.empty_result') }}</i></td>
        </tr>
    @endforelse
    </tbody>
</table>
