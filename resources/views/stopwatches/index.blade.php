@section('title')
    pomodoro
@stop

@section('content')
    <div class="box-row dashboard">
        <div class="box size-s-2">
            <div class="in tomatoes">
                <p><img src="http://www.legalproductivity.com/wp-content/uploads/2010/08/pomodoro_timer.jpg" alt="pomodoro"></p>
                <p><span class="timer" id="timer"></span></p>
                <button data-name="start">start</button>
                <button data-name="stop">stop</button>
            </div>
        </div>

        <div class="box size-s-1">
            <div class="in">
                <h2>stats today</h2>
                <div class="success">
                    <h3>success</h3>

                </div>
                <div class="fail">
                    <h3>fail</h3>

                </div>
            </div>
        </div>
    </div>

    {{--	{{ $pomodoro->end }}--}}
@stop

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {

        })
    </script>
@stop