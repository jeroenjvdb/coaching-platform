<html>
<style>
    table {
        width: 15px;
        border-spacing: 0;
    }
    tr {
        min-height: 5px;
    }
    .colored {
        background-color: #FF0000;
    }
</style>
<td colspan="8"><h1></h1></td>
<table cellpadding="5">
{{--<td colspan="8"></td>--}}
<tr>
    <td class="" colspan="10">{{ $training->group->name }}</td>
    {{--{{ $training->starttime }}--}}
    <td colspan="1" class="colored">{{ $training->starttime->format('l') }}</td>
</tr>
<tr>
    <td colspan="10"></td>
    <td colspan="1" class="colored">
        {{ $training->starttime->format('d/m/Y') }}
    </td>
</tr>
<tr>
    <td colspan="10"></td>
    <td colspan="1" class="colored">
        {{ $training->starttime->format('A') }}
    </td>
</tr>
@foreach($categories as $category)
        <tr>
            <td colspan="10"></td>
            <td colspan="1"></td>
        </tr>
    <tr>
        <td colspan="1"></td>
        <td colspan="8">{{ $category->category->name }}</td>
        <td colspan="2">{{ $category->total }}m</td>
    </tr>
        <tr>
            <td colspan="10"></td>
            <td colspan="1"></td>
        </tr>
    @foreach($category->exercises as $exercise)
        <tr>
            <td colspan="1">{{ $exercise->sets }}</td>
            <td colspan="1">X</td>
            <td colspan="1">{{ $exercise->meters }}</td>
            <td colspan="7">{{ $exercise->textarea }}</td>
            <td colspan="1">{{ $exercise->total }}</td>
        </tr>
    @endforeach
@endforeach
<tr>
    <td colspan="9"></td>
    <td colspan="1">totaal:</td>
    <td colspan="1">{{ $training->total }}m</td>
</tr>
</table>
</html>