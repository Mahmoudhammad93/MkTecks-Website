<!DOCTYPE html>
<html style="--theme-deafult:#ee3e36; --theme-secondary:#da007b;" lang="en" dir="{{ lang() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Ahmed Mohsen">
    <link rel="icon" href="{{ asset('dashboard') }}/assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('dashboard') }}/assets/images/favicon.png" type="image/x-icon">
    <title>{{ settings()->name }} - {{ $title }}</title>
    <!-- Google font-->

    <script src="https://kit.fontawesome.com/a33530bb41.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/icofont.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/scrollbar.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/style.css">

    <link id="color" rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/custom.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/vendors/selects2.min.css">
    @if (lang() == 'ar')
        <link rel="stylesheet" type="text/css" href="{{ asset('dashboard') }}/assets/css/custom-rtl.css">
    @endif

    @stack('styles')
</head>
