<head>
  <title>DOCH</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content="{{ csrf_token() }}" name="csrf-token"/>
 <base href="{{ route('home') }}">

  <link rel="shortcut icon" type="image/png" href="{{ asset('/doch/img/fevicon.png?dszd') }}"/>
  <link rel="stylesheet" href="{{ asset('/doch/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/doch/css/style.css') }}?v={{time()}}">
  <link rel="stylesheet" href="{{ asset('/doch/css/responsive.css') }}?v={{time()}}">
  <link rel="stylesheet" href="{{ asset('/doch/css/font-awesome.css') }}?v={{time()}}">
  <link rel="stylesheet" href="{{ asset('/doch/css/menubar.css') }}?v={{time()}}">
    
    @stack('css')
    
</head>
