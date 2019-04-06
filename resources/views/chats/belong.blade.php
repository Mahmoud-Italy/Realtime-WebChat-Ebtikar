 @foreach($belongs as $belong) 
    <div id="belongTo_{{$belong->id}}" class="belongContainer hidden">

      <div class="headind_srch beSrch">
          <div class="recent_heading w6per">
              <div class="incoming_msg_img"> 
                    <img src="https://ptetutorials.com/images/user-profile.png" alt="" class="mxW28">
                    @if($belong->online == 1)<div class="beOnlineAg"></div>@endif
              </div>
          </div>
          <div class="srch_bar textLeft w90per"> <p>&nbsp;{{$belong->name}}  <span id="isTyping-{{$belong->id}}"></span></p>
          <button class="clearChat" data-id="{{$belong->id}}" type="button">Clear Chat</button></div>
      </div>

        <div class="msg_history ">
            <div id="conversionSocket_{{$belong->id}}"></div>
            <div id="conversionLoading_{{$belong->id}}" class="textCenter">
              <img src="{{ url('img/loading.gif') }}" class="loadingGIF">
            </div>
        </div>

        <div class="type_msg">
          <div class="input_msg_write">
              <input type="text" id="textConversion_{{$belong->id}}" class="write_msg" placeholder="Type a message" />
              <button class="msg_send_btn" user-to="{{$belong->id}}" type="button">
              <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
          </div>
        </div>

    </div>
@endforeach