<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{$pageTitle ?? "Soda - Framework"}}</title>

	<script>var clicky_site_ids = clicky_site_ids || []; clicky_site_ids.push(101294415);</script>
	<script async src="//static.getclicky.com/js"></script>

    <script src="/vendor/vue/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link href="/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="/css/app.a2.css" rel="stylesheet">

    @yield('header')

</head>

<body>

    <div id="app" v-cloak>
        @yield('content')
    </div>

    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/popper.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="/vendor/notify/notify.min.js"></script>
    <script src='https://cdn.rawgit.com/lcdsantos/menuspy/fa5bc803/dist/menuspy.min.js'></script>

    <script>
        let mixin = {
            methods: {
                phoneNumberPattern: function(phone) {
                    return phone;
                }
            }
        }
    </script>

    <script>
        $.notify.addStyle('notif', {
            html: "<div><span data-notify-text/></div>",
            classes: {
                base: {
                    "opacity": "0.90",
                    "white-space": "nowrap",
                    "color": "#ffffff",
                    "border-radius": "5px",
                    "padding": "7px"
                },
                error: {
                    "background-color": "#B94A48",
                }
            }
        });
    </script>

    @yield('script')

</body>

</html>
