<html>
<td><h1>training</h1></td>
<tr>
    <td colspan="5">{{ $training->starttime }}</td>
</tr>
@foreach($training->exercises as $exercise)
    <tr>
        <td></td>
        <td>{{ $exercise->sets }}</td>
        <td>*</td>
        <td>{{ $exercise->meters }}</td>
        <td>{{ $exercise->description }}</td>
        <td>{{ $exercise->total }}</td>
    </tr>
@endforeach
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>total:</td>
    <td>{{ $training->total }}</td>
</tr>
</html>