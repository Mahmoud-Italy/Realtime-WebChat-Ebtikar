    <?php echo Form::Open(['id'=>'frmLogin','url'=>'login','class'=>'']); ?>

          <h2>Login</h2>

          <?php if(Session::has('error')): ?>
            <p class="alert alert-danger"><?php echo e(Session::get('error')); ?></p>
          <?php elseif(Session::has('warning')): ?>
            <p class="alert alert-warning"><?php echo e(Session::get('warning')); ?></p>
          <?php endif; ?>
          <?php if(Session::has('verify')): ?>
            <p class="alert alert-warning">Verify</p>
          <?php endif; ?>

          <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
          <?php endif; ?>
       
       
        <?php if(!Session::has('warning')): ?>
          <label>
            <p class="label-txt">EMAIL</p>
            <input type="text" class="input" name="email">
            <div class="line-box"><div class="line"></div></div>
          </label>
          <label>
            <p class="label-txt">PASSWORD</p>
            <input type="password" class="input" name="password" autocomplete="off">
            <div class="line-box"><div class="line"></div></div>
          </label>
          <button type="submit">Login</button> or <a href="javascript:void(0);" class="openSignup">Signup</a>
        <?php endif; ?>
    <?php echo Form::Close(); ?>