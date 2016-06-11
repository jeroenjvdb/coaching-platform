<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>A Simple Responsive HTML Email</title>
    <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;}
        .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
        .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
        .h1, .h2, .bodycopy {color: #153643; font-family: sans-serif;}
        table {margin: 0 10px;}
    </style>
</head>
<body yahoo bgcolor="#f6f8f1">
<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table class="content" bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr bgcolor="#d73925" height="70" style="padding: 10px 10px 10px 10px;">
                    <td >
                        <img src="{{ $message->embed(public_path() . '/resources/img/launcher-icon-2x.png') }}" width="70" height="70" border="0" alt="" / >
                    </td>
                    <td class="h1">Topswim</td>
                </tr>

                <tr>
                    {{--<td class="h1" style="padding: 5px 0 0 0;">--}}
                    {{--Responsive Email Magic--}}
                    {{--</td>--}}
                </tr>
                <tr>
                    <td>
                        @yield('content')
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
