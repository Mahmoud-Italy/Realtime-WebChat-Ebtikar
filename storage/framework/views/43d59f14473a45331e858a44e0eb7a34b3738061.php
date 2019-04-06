<!DOCTYPE html>
<html>
<head>
  <title></title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo e(url('css/login.css')); ?>">
    <script src="<?php echo e(url('js/login.js')); ?>"></script>
</head>
<body>


    <form id="frmLogin">
      <h2>Login</h2>
          <label>
            <p class="label-txt">EMAIL</p>
            <input type="text" class="input">
            <div class="line-box"><div class="line"></div></div>
          </label>
          <label>
            <p class="label-txt">PASSWORD</p>
            <input type="text" class="input">
            <div class="line-box"><div class="line"></div></div>
          </label>
          <button type="submit">Login</button> or <a href="javascript:void(0);" class="openSignup">Signup</a>
    </form>

    <form id="frmSignup" class="hidden">
      <h2>Signup</h2>
          <label>
            <p class="label-txt">NAME</p>
            <input type="text" class="input">
            <div class="line-box"><div class="line"></div></div>
          </label>
          <label>
            <p class="label-txt">EMAIL</p>
            <input type="text" class="input">
            <div class="line-box"><div class="line"></div></div>
          </label>
          <label>
            <p class="label-txt">PASSWORD</p>
            <input type="text" class="input">
            <div class="line-box"><div class="line"></div></div>
          </label>
          <button type="submit">Signup</button> or <a href="javascript:void(0);" class="openLogin">Login</a>
    </form>

</body>
</html>