<!DOCTYPE html>
<html>
<head>
	 <title>Chat Window</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
    <meta name="csrf-token" content="{{ auth()->user()->api_token }}">
    @endauth
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ url('css/style.css') }}">
</head>
<body>

      <div class="container">
    	   <h3 class=" text-center">Chat Window <a href="{{ url('logout') }}" class="f11">Logout</a></h3>
          <p class="textCenter f11">Welcome Back, {{ Auth::user()->name }}</p>
    	   <div class="messaging">
            <div class="inbox_msg">
                @include('chats.recent')
                <div class="mesgs">
                  @include('chats.belong')
                </div>
            </div>
        </div>
      </div>

  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.dev.js"></script>
  @include('chats.jsCode')
</body>
</html>