<h2>about</h2>
<a href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a>
<h3>aanwezigheden</h3>
<div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $swimmer->presence * 100 }}%"
         aria-valuemin="0" aria-valuemax="100" style="width: {{ $swimmer->presence * 100 }}%">
        {{ $swimmer->presence * 100 }}%
    </div>
</div>
<h3>ochtendpolsen</h3>
<div class="row">
    <div class="col-md-4 col-md-offset-8">
        <div id="daterangepicker" class="pull-right " style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <b class="caret"></b>
        </div>
    </div>
</div>
<canvas id="canvas" class="chart"
        @if($myProfile)
            data-url="{{ route('me.heartRate', [
                'group' => $swimmer->group->slug,
            ]) }}"
        @else
            data-url="{{ route('{group}.swimmer.heartRate', [
                'group' => $group->slug,
                'swimmer' => $swimmer->slug,
            ]) }}"
        @endif
></canvas>
@include('swimmers.show.data')
