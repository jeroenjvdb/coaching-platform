<div class="category exercise-ui row">
    @if($editable)
    <div class="sort-bars col-xs-1"><i class="fa fa-bars"></i></div>
    @endif
    <div class="col-xs-4 {{ $editable ? '' : 'col-xs-offset-1' }}">
        <div class="">{{ $category->category->name }}</div>
    </div>
    <div class="col-xs-6">
        {{ $category->total }}m
    </div>
    <div class="col-xs-1 no-gutter  ">
        @if($editable)
        <a href="#" data-toggle="add-exercise-{{ $category->id }}"><i class="fa fa-plus"></i><span
                    class="sr-only">Add new exercise</span></a>
        @endif
    </div>
</div>