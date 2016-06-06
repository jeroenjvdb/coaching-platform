<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}">

    <title>@yield('title') | coaching platform | KAZSC</title>

    <!-- manifest -->

    <meta name="viewport" content="width=device-width">
    <meta name="application-name" content="topswim">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="36x36" href="/resources/img/launcher-icon-0-75x.png">
    <link rel="icon" sizes="48x48" href="/resources/img/launcher-icon-1x.png">
    <link rel="icon" sizes="72x72" href="/resources/img/launcher-icon-1-5x.png">
    <link rel="icon" sizes="96x96" href="/resources/img/launcher-icon-2x.png">
    <link rel="icon" sizes="144x144" href="/resources/img/launcher-icon-3x.png">
    <link rel="icon" sizes="192x192" href="/resources/img/launcher-icon-4x.png">
    <link rel="manifest" href="manifest.webmanifest">


    <!-- Styles -->
    <link href="/resources/css/adminLTE.css" rel="stylesheet">
    <link href="/resources/css/skin.css" rel="stylesheet">
    <link href="/resources/css/main.css" rel="stylesheet">


</head>
<body class="variation">

@yield('content')

</body>
</html>