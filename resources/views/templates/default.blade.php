<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatty @yield('title')</title>
   @include('templates.partials.style')
    @yield('style')
</head>
<body>
@include('templates.partials.navigation')
<div class="container">
    @include('templates.partials.alerts')
    @include('templates.partials.scripts')
    @yield('content')
    @yield('scripts')
</div>
</body>
</html>