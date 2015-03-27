<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800">
        <title>{{ Config::get('recycle.name') }} Authentication</title>
        <link href="{{ url() }}/assets/css/application.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="{{ url() }}/assets/css/admin.auth.css" media="screen" rel="stylesheet" type="text/css" />
        <script src="{{ url() }}/assets/js/application.js" type="text/javascript"></script>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-inverse navbar-static-top" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url() }}/admin/auth">{{ Config::get('recycle.name') }}</a>
            </div>
        </nav>
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
