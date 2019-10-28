<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="BrsvyJXZ3aT7jJwtluoEavbJEucKN5RBkJS0ilZm">
    <base href="/">
    <!-- Compiled and minified CSS -->

    <title>Document</title>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">

</head>
<body @php echo config('content.static-bg', true) ? 'class="var1"' : ''  @endphp>
@yield('page-wrapper')
</body>
@include('layouts.scripts')
</html>
