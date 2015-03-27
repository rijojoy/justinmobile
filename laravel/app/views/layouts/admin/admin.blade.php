<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800">
        <title>{{ Config::get('recycle.name') }} &mdash; Dashboard</title>
        <link href="{{ url() }}/assets/css/application.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="{{ url() }}/assets/css/admin.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="{{ url() }}/assets/css/admin.statuses.css" media="screen" rel="stylesheet" type="text/css" />
        <script src="{{ url() }}/assets/js/application.js" type="text/javascript"></script>
        <script src="{{ url() }}/assets/js/op.js" type="text/javascript"></script>
    </head>
    <body>
        <?php $my = Sentry::getUser(); ?>
        <nav class="navbar navbar-default navbar-inverse navbar-static-top" role="navigation">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url() }}/admin/dashboard">{{ Config::get('recycle.name') }}</a>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse-primary">
                    <span class="sr-only">Toggle Side Navigation</span>
                    <i class="icon-th-list"></i>
                </button>

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse-top">
                    <span class="sr-only">Toggle Top Navigation</span>
                    <i class="icon-align-justify"></i>
                </button>

            </div>
            
            <ul class="nav navbar-nav navbar-left">
                <li class="cdrop navbar-payattentiontome">
                    <a href="/">homepage</a>
                </li>
            </ul>
            
            <div class="collapse navbar-collapse navbar-collapse-top">
                <div class="navbar-right">
                    <form class="navbar-form navbar-left" role="search" method="GET" action= "{{ url() }}/admin/orders">
                        <div class="form-group">
                            <input type="text" name="imei" class="search-query animated" placeholder="Find IMEI">
                            <i class="icon-search"></i>
                        </div>
                    </form>
                    
                    <form class="navbar-form navbar-left" role="search" method="GET" action= "{{ url() }}/admin/orders">
                        <div class="form-group">
                            <input type="text" name="order" class="search-query animated" placeholder="Find Order">
                            <i class="icon-search"></i>
                        </div>
                    </form>
                    
                    <form class="navbar-form navbar-left" role="search" method="GET" action= "{{ url() }}/admin/orders">
                        <div class="form-group">
                            <input type="text" name="search" class="search-query animated" placeholder="Search">
                            <i class="icon-search"></i>
                        </div>
                    </form>
                    
                    <ul class="nav navbar-nav navbar-left">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle dropdown-avatar" data-toggle="dropdown">
                                <span>
                                    <img class="menu-avatar" src="/assets/images/avatars/{{ $my->id }}.jpg" /> <span>{{ $my->first_name }} <i class="icon-caret-down"></i></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="with-image">
                                    <span>{{ $my->first_name }}</span>
                                </li>

                                <li class="divider"></li>

                                <li><a href= "{{ url() }}/admin/users/{{ $my->id }}/edit"><i class="icon-cog"></i> <span>Settings</span></a></li>
                                <li><a href= "{{ url() }}/admin/auth/logout"><i class="icon-off"></i> <span>Logout</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="sidebar-background">
            <div class="primary-sidebar-background"></div>
        </div>

        <div class="primary-sidebar">
            <ul class="nav navbar-collapse collapse navbar-collapse-primary">
                <?php $navigation = array(
                    'dashboard' => array(
                        'route' => 'dashboard',
                        'icon' => 'home',
                        'label' => 'Dashboard'
                    ),
                    'orders' => array(
                        'route' => 'orders',
                        'icon' => 'truck',
                        'label' => 'Orders'
                    ),
                    'products' => array(
                        'route' => 'products',
                        'icon' => 'mobile-phone',
                        'label' => 'Products'
                    ),
                    'users' => array(
                        'route' => 'users',
                        'icon' => 'group',
                        'label' => 'Users'
                    ),
					'documentation' => array(
						'route' => 'documentation',
						'icon' => 'book',
						'label' => 'Documentation'
					)
                ); ?>
                @foreach ($navigation as $nav_item) 
                <li class="{{ Request::is("admin/{$nav_item['route']}*") ? 'active' : '' }}">
                    <span class="glow"></span>
                    <a href="{{ url() }}/admin/{{ $nav_item['route'] }}">
                        <i class="icon-{{ $nav_item['icon'] }} icon-2x"></i>
                        <span>{{ $nav_item['label'] }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        
        <div class="main-content">
            <div class="container">
                <div class="row">

                    <div class="area-top clearfix">
                        <div class="pull-left header">
                            <h3 class="title">
                                <i class="icon-home"></i>
                                Dashboard
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container padded">
                <div class="row">
                    <div id="breadcrumbs">
                        @yield('breadcrumbs')
                    </div>
                    @if(Session::has('message'))
                        <div class="alert alert-global alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ Session::get('message') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="container">
                @yield('content')
            </div>
        </div>
    </body>
</html>