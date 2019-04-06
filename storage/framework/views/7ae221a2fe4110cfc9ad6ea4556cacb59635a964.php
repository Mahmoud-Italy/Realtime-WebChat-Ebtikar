 <?php $__currentLoopData = $belongs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $belong): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
    <div id="belongTo_<?php echo e($belong->id); ?>" class="belongContainer hidden">

      <div class="headind_srch beSrch">
          <div class="recent_heading w6per">
              <div class="incoming_msg_img"> 
                    <img src="https://ptetutorials.com/images/user-profile.png" alt="" class="mxW28">
                    <?php if($belong->online == 1): ?><div class="beOnlineAg"></div><?php endif; ?>
              </div>
          </div>
          <div class="srch_bar textLeft w90per"> <p>&nbsp;<?php echo e($belong->name); ?>  <span id="isTyping-<?php echo e($belong->id); ?>"></span></p>
          <button class="clearChat" data-id="<?php echo e($belong->id); ?>" type="button">Clear Chat</button></div>
      </div>

        <div class="msg_history ">
            <div id="conversionSocket_<?php echo e($belong->id); ?>"></div>
            <div id="conversionLoading_<?php echo e($belong->id); ?>" class="textCenter">
              <img src="<?php echo e(url('img/loading.gif')); ?>" class="loadingGIF">
            </div>
        </div>

        <div class="type_msg">
          <div class="input_msg_write">
              <input type="text" id="textConversion_<?php echo e($belong->id); ?>" class="write_msg" placeholder="Type a message" />
              <button class="msg_send_btn" user-to="<?php echo e($belong->id); ?>" type="button">
              <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
          </div>
        </div>

    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>