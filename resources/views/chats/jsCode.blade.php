<script> const socket = io.connect("//localhost:8002/", { secure: true }); </script>
<script>var myDignostic = {{App\User::MyID()}}</script>

<script>
 // emit for Online 
 socket.on('connect', function() {
  var userId = myDignostic;
  socket.emit('online', userId);
 });
</script>


<script>
 // Create Typing...
  function createTyping(user_from,user_to,status) {
    var data = {
      user_from : user_from,
      user_to : user_to,
      status: status,
      deviceType: 'web'
    };
    socket.emit('typing',data);
  };

 // listen on Typing...
  socket.on("typing", function(data) {
    pushTyping(data.user_from,data.user_to,data.status);
  });
  
  // Push Typing..
  function pushTyping(user_from,user_to,status) {
    if(status == "true") {
      $("#isTyping-"+user_from).text('typing....');
    } else {
      $("#isTyping-"+user_from).text('');
    }
  };
</script>


<script>
	// Send Message
	// Step 01
	$(".msg_send_btn").click(function(){
        var user_to = $(this).attr('user-to');
        var message = $("#textConversion_"+user_to).val();
        var data = {
            user_from : myDignostic,
            user_to : user_to,
            message: message,
            deviceType: 'web'
        };          
        socket.emit('chat_emit', data);
	});

    // Step 02
	socket.on("chat_listen", function(data) {
	    pushMessage(data);
	});

	// Step 03
	function pushMessage(data) {
	var divMessage = nl2br(data.message);
   		$("#conversionSocket_"+data.user_from).append('<div class="incomfing_msg"><div class="incoming_msg_img"><img src="https://ptetutorials.com/images/user-profile.png"> </div><div class="received_msg"><div class="received_withd_msg"><p> '+divMessage+' </p><span class="time_date">1min ago</span></div></div></div>');
   		$("#conversionSocket_"+data.user_to).append('<div class="outgoing_msg"><div class="sent_msg"><p> '+divMessage+' </p><span class="time_date">1min ago</span></div></div>');
   		$("#textConversion_"+data.user_to).val('');
  	};
    
    // fix space and break in message
	function nl2br (str, is_xhtml) {
	    if (typeof str === 'undefined' || str === null) {
	        return '';
	    }
	    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
	    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}
</script>

<script>
	// On Click Recent Peoples
	$('.chat_list').click(function(){
		var userId = $(this).attr('data-id');
		$('.chat_list').removeClass('active_chat');
		$(this).addClass('active_chat');
		$("#sendBtn").attr('user-to',userId);

		$('.belongContainer').addClass('hidden');
	    $("#belongTo_"+userId).removeClass('hidden');
	    $("#conversionLoading_"+userId).removeClass('hidden');

		var Url = "{{ url('json/load/chats') }}";
		$.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
	    $.ajax({
	        url : Url,
	        type : "POST",
	        data : { userId:userId },
	        dataType : "json",
	        success : function(data) {
	        	if(data.status) {
	        		$("#conversionSocket_"+userId).html('');
	        		$("#conversionLoading_"+userId).addClass('hidden');
                    $("#conversionSocket_"+userId).html(data.html);
	        	}
	        }, error : function(data) {  }
      	});
	    return false;
	});
</script>



<script>
	// Clear Chat
	$(".clearChat").click(function(){
        var conId = $(this).attr('data-id');
        $("#conversionSocket_"+conId).html('');
	});
</script>
