    <div class="inbox_people">
          <div class="headind_srch">
              <div class="recent_heading"> <h4>Recent</h4></div>
              <div class="srch_bar">
                <div class="stylish-input-group"></div>
              </div>
          </div>
          <div class="inbox_chat">

              <?php $__currentLoopData = $recent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div id="list-<?php echo e($rec->id); ?>" class="chat_list" data-id="<?php echo e($rec->id); ?>" >
                      <div class="chat_people">
                        <div class="chat_img"> 
                          <img src="https://ptetutorials.com/images/user-profile.png" alt=""> 
                          <?php if($rec->online == 1): ?><div class="beOnline"></div><?php endif; ?>
                        </div>
                        <div class="chat_ib">
                          <h5><?php echo e($rec->name); ?> 
                            <span class="chat_date"><?php if($rec->count_unread_msg > 0): ?> <?php echo e($rec->count_unread_msg); ?> <?php endif; ?></span></h5>
                            <p><?php echo e($rec->last_message); ?></p>
                        </div>
                      </div>
                  </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          </div>
      </div>