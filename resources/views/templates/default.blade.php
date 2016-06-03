<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatty @yield('title')</title>
   @include('templates.partials.style')
</head>
<body>
@include('templates.partials.navigation')
<div class="container">
    @include('templates.partials.scripts')
    @yield('content')
</div>
</body>
</html>