<!DOCTYPE html>
<html>
<head>
	 <title>Chat Window</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php if(auth()->guard()->check()): ?>
    <meta name="csrf-token" content="<?php echo e(auth()->user()->api_token); ?>">
    <?php endif; ?>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo e(url('css/style.css')); ?>">
</head>
<body>

      <div class="container">
    	   <h3 class=" text-center">Chat Window <a href="<?php echo e(url('logout')); ?>" class="f11">Logout</a></h3>
          <p class="textCenter f11">Welcome Back, <?php echo e(Auth::user()->name); ?></p>
    	   <div class="messaging">
            <div class="inbox_msg">
                <?php echo $__env->make('chats.recent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="mesgs">
                  <?php echo $__env->make('chats.belong', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
      </div>

  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.dev.js"></script>
  <?php echo $__env->make('chats.jsCode', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>