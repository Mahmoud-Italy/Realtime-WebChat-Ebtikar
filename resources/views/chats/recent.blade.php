    <div class="inbox_people">
          <div class="headind_srch">
              <div class="recent_heading"> <h4>Recent</h4></div>
              <div class="srch_bar">
                <div class="stylish-input-group"></div>
              </div>
          </div>
          <div class="inbox_chat">

              @foreach($recent as $rec)
                  <div id="list-{{$rec->id}}" class="chat_list" data-id="{{$rec->id}}" >
                      <div class="chat_people">
                        <div class="chat_img"> 
                          <img src="https://ptetutorials.com/images/user-profile.png" alt=""> 
                          @if($rec->online == 1)<div class="beOnline"></div>@endif
                        </div>
                        <div class="chat_ib">
                          <h5>{{$rec->name}} 
                            <span class="chat_date">@if($rec->count_unread_msg > 0) {{$rec->count_unread_msg}} @endif</span></h5>
                            <p>{{$rec->last_message}}</p>
                        </div>
                      </div>
                  </div>
              @endforeach

          </div>
      </div>