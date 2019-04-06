  <?php $__currentLoopData = $conversion->reverse(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $con): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
      <div class="<?php if($con->id != App\User::MyID()): ?> incoming_msg <?php else: ?> outgoing_msg <?php endif; ?>">
          <?php if($con->id != App\User::MyID()): ?>
              <div class="incoming_msg_img"> 
                  <img src="https://ptetutorials.com/images/user-profile.png" alt=""> 
              </div>
              <div class="received_msg">
                  <div class="received_withd_msg">
                    <p><?php echo e($con->message); ?></p>
                    <span class="time_date"><?php echo e(App\Chat::timeElapsed($con->created_at)); ?></span>
                  </div>
              </div>
          <?php else: ?>
              <div class="sent_msg">
                  <p ><?php echo e($con->message); ?></p>
                  <span class="time_date"><?php echo e(App\Chat::timeElapsed($con->created_at)); ?></span> 
              </div>
          <?php endif; ?>
      </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>