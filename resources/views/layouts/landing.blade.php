<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body.variation {
            background: #32323A;
        }

        .login-box {
            width: 100%;
            max-width: 250px;
            margin: 150px auto;
            background: #eaeaec;
            position: relative;
            overflow: hidden;
            -moz-border-radius: 8px;
            -webkit-border-radius: 8px;
            border-radius: 8px;
        }

        .login-box .in {
            padding: 20px;
        }

        .login-box .field {
            width: 100%;
            float: left;
            margin: 10px 0 0 0;
        }

        input[type=text], input[type=password], input[type=email], input[type=url], textarea {
            padding: 10px;
            height: 40px;
            width: 100%;
            max-width: 100%;
            background: #fff;
            border: 1px solid #d6d6d6;
            -moz-border-radius: 8px;
            -webkit-border-radius: 8px;
            border-radius: 8px;
        }

        .login-box .visual {
            width: 50%;
            overflow: hidden;
            margin: 0 auto 10px;
        }

        .login-box .field .btn,
        .login-box .field .dataTables_wrapper .dataTables_paginate a,
        .dataTables_wrapper .dataTables_paginate .login-box .field a {
            display: block;
            width: 100%;
            text-align: center;
        }

        .btn, .dataTables_wrapper .dataTables_paginate a {
            display: inline-block;
            padding: 10px 20px;
            //background: #e11b22;
            color: #fff;
            border: none;
            outline: none;
            font-size: 13px;
            line-height: 18px;
            -webkit-font-smoothing: antialiased !important;
            -moz-border-radius: 8px;
            -webkit-border-radius: 8px;
            border-radius: 8px;
            -moz-transition: background-color, 125ms;
            -o-transition: background-color, 125ms;
            -webkit-transition: background-color, 125ms;
            transition: background-color, 125ms;
        }

        .groups{
            color:white;
        }
    </style>

</head>
<body class="variation">

@yield('content')

</body>
</html>