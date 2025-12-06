<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> @yield('title', $title ?? 'Auth') </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="dashboard template,dashboard html,bootstrap admin,dashboard admin,admin template,sales dashboard,crypto dashboard,projects dashboard,html template,html,html css,admin dashboard template,html css bootstrap,dashboard html css,pos system,bootstrap dashboard">
    <!-- Favicon -->
    <link rel="icon" href="/assets/images/brand-logos/favicon.ico" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="/assets/js/authentication-main.js"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="/assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" >

    <!-- Style Css -->
    <link href="/assets/css/styles.css" rel="stylesheet" >

    <!-- Icons Css -->
    <link href="/assets/css/icons.css" rel="stylesheet" >

    <link rel="stylesheet" href="/assets/libs/toastify-js/src/toastify.css">

    @livewireStyles

</head>

<body class="bg-white">

    {{ $slot ?? '' }}
    @yield('content')

    <!-- Bootstrap JS -->
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Show Password JS -->
    <script src="/assets/js/show-password.js"></script>

    <script src="/assets/libs/toastify-js/src/toastify.js"></script>

    @include('layouts.notification')

    @livewireScripts

</body>

</html>
