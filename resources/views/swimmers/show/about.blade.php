<h2>About</h2>
<h3>Aanwezigheden</h3>
<div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="{{ $swimmer->presence * 100 }}%"
         aria-valuemin="0" aria-valuemax="100" style="width: {{ $swimmer->presence * 100 }}%">
        {{ $swimmer->presence * 100 }}%
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-6">
        <div id="daterangepicker" class="pull-right " style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
            <i class="fa fa-calendar"></i>&nbsp;
            <span></span> <b class="caret"></b>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h3>Ochtendpolsen</h3>
        <canvas id="canvas" class="chart" height="250"
                                  data-url="{{ route('{group}.swimmer.heartRate', [
                'group' => $group->slug,
                'swimmer' => $swimmer->slug,
            ]) }}"
        ></canvas></div>
    <div class="col-md-6">
        <h3>Gewicht</h3>
        <canvas id="canvas2" class="chart" height="250"
                data-url="{{ route('{group}.swimmer.weights', [
                'group' => $group->slug,
                'swimmer' => $swimmer->slug,
            ]) }}"
        ></canvas>
    </div>
</div>



@include('swimmers.show.contact')

