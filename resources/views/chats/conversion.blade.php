  @foreach($conversion->reverse() as $con)    
      <div class="@if($con->id != App\User::MyID()) incoming_msg @else outgoing_msg @endif">
          @if($con->id != App\User::MyID())
              <div class="incoming_msg_img"> 
                  <img src="https://ptetutorials.com/images/user-profile.png" alt=""> 
              </div>
              <div class="received_msg">
                  <div class="received_withd_msg">
                    <p>{{$con->message}}</p>
                    <span class="time_date">{{App\Chat::timeElapsed($con->created_at)}}</span>
                  </div>
              </div>
          @else
              <div class="sent_msg">
                  <p >{{$con->message}}</p>
                  <span class="time_date">{{App\Chat::timeElapsed($con->created_at)}}</span> 
              </div>
          @endif
      </div>
  @endforeach