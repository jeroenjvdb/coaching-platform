<h2>chrono</h2>
@foreach($stopwatches as $stopwatch)
    <a href="{{ route('stopwatches.show', [
                        'group' => $group->slug,
                        'id' => $stopwatch->id,
                        ]) }}">
        {{ $stopwatch->distance->distance }}
        {{ $stopwatch->distance->stroke->name }}
    </a></br>
@endforeach