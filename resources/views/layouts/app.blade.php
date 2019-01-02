<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/laracrud/coreui.min.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    @stack('head')
</head>
<body class="@yield('bodyClass', 'app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show')">
    {{--Header--}}
    @include('laracrud::includes.header')
    <div class="app-body">
        {{--Sidebar--}}
        @include('laracrud::includes.sidebar')

        {{--Main content--}}
        <main class="main">
            {!! Breadcrumbs::render() !!}

            <div class="container-fluid">
                @include('laracrud::includes.messages')

                <div class="row">
                    <div class="col-sm-4">
                        <h1 class="h4">
                            @yield('header')
                        </h1>
                    </div>
                    <div class="col-sm-8 text-right">
                        @stack('actions')
                    </div>
                </div>

                @yield('content')
            </div>
        </main>
    </div>

    {{--Footer--}}
    @include('laracrud::includes.footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="{{ asset('vendor/laracrud/coreui.min.js') }}"></script>
    <script src="{{ asset('vendor/laracrud/coreui-utilities.min.js') }}"></script>
    <script>
      $(function() {
        /**
         * Find data-confirm-message="" and add confirmation dialog
         */
        $('body').on('click', 'a[data-confirm-message]', function(e) {
          e.preventDefault();

          var link = $(this);

          if (confirm(link.attr('data-confirm-message'))) {
            return true;
          } else {
            e.stopPropagation();
            e.stopImmediatePropagation();

            return false;
          }
        });

        /**
         * Find data-method="" and submit links as form
         */
        $('body').on('click', 'a[data-method]', function(e) {
          e.preventDefault();

          var target = '_self';
          var link = $(this);
          var token = $('meta[name="csrf-token"]').attr('content');

          if (link.attr('target')) {
            target = link.attr('target');
          }

          $('<form action="' + link.attr('href') + '" method="POST" target="' + target + '" style="display:none">\n' +
              '<input type="hidden" name="_method" value="' + link.attr('data-method') + '">\n' +
              '<input type="hidden" name="_token" value="' + token + '">\n' +
              '</form>').appendTo('body').submit().remove();
        });
      });
    </script>
    @stack('scripts')
</body>
</html>
