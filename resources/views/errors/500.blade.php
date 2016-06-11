@extends('layouts.landing')

@section('title', '500 something went wrong')

@section('content')

    <div class="error-page">
        <h2 class="headline"> 500</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning"></i> Oeps! Er is iets misgegaan.
            </h3>

            <div class="input-group-btn">
                <a href="/" name="submit" class="btn btn-primary btn-full"><i class="fa fa-back"></i> terug naar de homepage
                </a>
            </div>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->
@endsection