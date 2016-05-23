<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<ul>
    @foreach($categories as $category)
        <li>
            {{ $category->category->name }} <br>
            <ul>
                @foreach($category->exercises as $exercise)
                    <li>{{ $exercise->description }}</li>
                @endforeach
            </ul>
        </li>
    @endforeach

    {{--@foreach($categories as $category)--}}
        {{--{{ $category->category->name }}--}}
    {{--@endforeach--}}
</ul>
</body>
</html>