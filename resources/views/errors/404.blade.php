@extends('layouts.landing')

@section('title', '404 pagina niet gevonden')

@section('content')

    <div class="error-page">
        <h2 class="headline"> 404</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning"></i> Oeps! Deze pagina is niet gevonden.
            </h3>
            <p>
                De pagina die U zocht is niet gevonden.
            </p>
            <div class="input-group-btn">
                <a href="/" name="submit" class="btn btn-primary btn-full"><i class="fa fa-back"></i> terug naar de homepage
                </a>
            </div>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->
@endsection