@extends('layouts.landing')

        <!-- Main Content -->
@section('content')
    <div class="box box-danger login-box">
        <div class="box-header">
            <h1>Reset Password</h1>
        </div>
        <div class="box-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            {!! Form::open(['url' => '/password/email']) !!}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label">E-Mail Address</label>

                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                </div>

                <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-full">
                            <i class="fa fa-btn fa-envelope"></i>Send Password Reset Link
                        </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
