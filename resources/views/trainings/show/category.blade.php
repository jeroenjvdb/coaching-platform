<div class="category exercise-ui row">
    @if($editable)
        <div class="sort-bars col-xs-1"><i class="fa fa-bars"></i></div>
    @endif
    <div class="col-xs-4 {{ $editable ? '' : 'col-xs-offset-1' }}">
        <div class="">{{ $category->category->name }}</div>
    </div>
    <div class="col-xs-5">
        {{ $category->total }}m
    </div>
    <div class="col-xs-1 no-gutter  ">
        @if($editable)
            <a href="#" data-toggle="add-exercise-{{ $category->id }}"><i class="fa fa-plus"></i><span
                        class="sr-only">categorie toevoegen</span></a>
        @endif
    </div>
    <div class="col-xs-1 no-gutter  ">
        @if($editable)
            {!! Form::open([
                'route' => [
                    '{group}.training.category.destroy',
                    'training_id' => $training->id,
                ],
                'method' => 'delete',

            ]) !!}
        {!! Form::hidden('category_id', $category->id) !!}
            <button type="submit" class="btn btn-default btn-no-border btn-lg">
                <i class="fa fa-times"></i><span class="sr-only">categorie verwijderen</span>
            </button>
            {!! Form::close() !!}
        @endif
    </div>
</div>