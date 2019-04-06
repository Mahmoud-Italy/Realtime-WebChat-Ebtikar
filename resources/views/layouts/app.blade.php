<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" type="text/css" href="{{ url('css/login.css') }}">
</head>
<body>

  <div class="container">
     @include('layouts.login')
     @include('layouts.signup')
  </div>

  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="{{ url('js/login.js') }}"></script>
</body>
</html>