<h2>Stopwatch</h2>
@foreach($stopwatches as $stopwatch)
    <a rel="external" href="{{ route('stopwatches.show', [
                        'group' => $group->slug,
                        'id' => $stopwatch->id,
                        ]) }}">
        {{ $stopwatch->distance->distance }}
        {{ $stopwatch->distance->stroke->name }}
    </a></br>
@endforeach