<!DOCTYPE html>
<html>
<head>
    <title>CheckCheck</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Fira+Sans');
        @import url('https://fonts.googleapis.com/css?family=Indie+Flower');

        body {
            font-family: 'Fira Sans', sans-serif;
            font-size: 18px;
        }

        #checklistItems {
            font-family: 'Indie Flower', cursive;
            font-size: larger;
            line-height: 38px;
        }

        .completed {
            text-decoration: line-through;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <header class="mb-4 p-3 text-center rounded-bottom">
                    <a href="/">
                        <div class="d-inline p-2 rounded">
                            <i class="fa fa-lg fa-check-double text-success"></i>
                        </div>
                    </a>
                </header>
            </div>
        </div>
    </div>

    @yield('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
