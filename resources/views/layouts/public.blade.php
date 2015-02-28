<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        Cuatro en linea - @yield('title')
    </title>
    
    
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

</head>
<body>
    
    <div class="container main-content">
        @yield('content')
    </div>

    <script src="<?php echo asset('js/jquery/jquery.js'); ?>"></script>
    <script src="<?php echo asset('js/pusher/pusher.js'); ?>"></script>
    <script src="<?php echo asset('js/app.js'); ?>"></script>    

    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/board.css') }}"/>
</body>
</html>
