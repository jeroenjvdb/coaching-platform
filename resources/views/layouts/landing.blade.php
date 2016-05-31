<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}">

    <title>@yield('title') | coaching platform | KAZSC</title>

    <meta name="viewport" content="width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="400x400" href="/icon.png">
    <!--<link rel="manifest" href="/manifest.json">-->

    <!-- Styles -->
    <link href="/resources/css/adminLTE.css" rel="stylesheet">
    <link href="/resources/css/skin.css" rel="stylesheet">
    <link href="/resources/css/main.css" rel="stylesheet">


</head>
<body class="variation">

@yield('content')

</body>
</html>