<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800">
        <title>{{ Config::get('recycle.name') }} &mdash; 404</title>
        <link href="{{ url() }}/assets/css/application.css" media="screen" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <nav class="navbar navbar-default navbar-inverse navbar-static-top" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">{{ Config::get('recycle.name') }}</a>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="error-box">
                        <div class="message-small">Whoa! This page is missing.</div>
                        <div class="message-big">404</div>
                        @if (Sentry::getUser()) 
                        <div style="margin-top: 50px">
                            <a class="btn btn-blue" href= "{{ url() }}/admin/dashboard">
                                <i class="icon-arrow-left"></i> Back to dashboard
                            </a>
                        </div>
						@else
                        <div style="margin-top: 50px">
                            <a class="btn btn-blue" href="/">
                                <i class="icon-arrow-left"></i> Back to Homepage
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>