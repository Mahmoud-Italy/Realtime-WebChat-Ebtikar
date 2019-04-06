    <?php echo Form::Open(['id'=>'frmSignup','url'=>'signup','class'=>'hidden']); ?>

        <h2>Signup</h2>

          <?php if(Session::has('error')): ?>
            <p class="alert alert-danger"><?php echo e(Session::get('error')); ?></p>
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

          <label>
              <p class="label-txt">NAME</p>
              <input type="text" class="input" name="name">
              <div class="line-box"><div class="line"></div></div>
          </label>
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
        <button type="submit">Signup</button> or <a href="javascript:void(0);" class="openLogin">Login</a>
      <?php echo Form::Close(); ?>