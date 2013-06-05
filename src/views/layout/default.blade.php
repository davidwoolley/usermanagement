<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Sandbox Application</title>
        <meta name="viewport" content="width=device-width">
        <link href="{{{ asset('assets/css/bootstrap.css') }}}" rel="stylesheet">
        <link href="{{{ asset('assets/css/bootstrap-responsive.css') }}}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="navbar">
                <div class="navbar-inner">
                    <a class="brand" href="#">Sandbox Application</a>
                    <ul class="nav">
                    @if (Sentry::check()) 
                            <li><a href="{{{ URL::to('/') }}}">Home</a></li>
                        </ul>
                        <ul class="nav pull-right">
                            <li class="divider-vertical"></li>
                            <li><a href="{{{ URL::to('/logout') }}}">Logout</a></li>
                        </ul>
                    @else
                        <li><a href="{{{ URL::to('/') }}}">Home</a></li>
                        </ul>
                        <ul class="nav pull-right">
                            <li><a href="{{ URL::to('/register') }}">Register</a></li>
                            <li><a href="{{ URL::to('/login') }}">Login</a></li>
                        </ul>
                    @endif
                </div>
            </div>
            <div class="row">
                <div id="content" class="span9">
                    @yield('content')
                </div>
                <div class="span3">
                    @section('sidebar')
                    <div class='well'>
<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vel risus felis, non tempus nunc. Fusce gravida ultricies iaculis. Suspendisse sed libero sem. Aenean felis dolor, consequat a commodo a, aliquet non tortor. Vestibulum dignissim tincidunt lectus, a laoreet tortor dictum nec. Quisque posuere lacus sed ipsum aliquam facilisis. Duis in consequat dui. Mauris at magna erat, suscipit gravida diam.</p>
<p>Aenean nec nibh tortor. In sollicitudin mattis aliquet. Cras adipiscing commodo justo, ac sollicitudin enim tincidunt ac. Vestibulum fermentum quam non diam semper mollis. Curabitur sem nibh, auctor sed tristique sit amet, tincidunt id odio. Nam porta, dolor at posuere aliquam, erat ipsum consequat arcu, eget luctus eros ante et mauris. Donec venenatis, nunc a venenatis imperdiet, arcu dolor convallis tortor, sed sollicitudin neque felis nec turpis. Maecenas in neque sit amet diam dapibus laoreet. Mauris in massa eget sem elementum lacinia id eget quam. Ut sit amet velit augue. Ut diam turpis, molestie at semper vel, volutpat a purus. Pellentesque non risus nibh. </p>                        
                    </div>
                    @show
                </div>
            </div>
        </div>
	<script src="{{{ asset('assets/js/jquery.v1.8.3.min.js') }}}"></script>
        <script src="{{{ asset('assets/js/bootstrap/bootstrap.min.js') }}}"></script>
    </body>
</html>
