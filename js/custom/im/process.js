$j(document).ready(function()
{
	//prefill last history messages
	showHistory(window.history_messages);
	
	//send message
	$j("#im_form").submit(function()
	{
		var message_text = $j("#message").val();
		
		if(message_text.replace(/^s+/,'')!='')//if there are some chars except spaces in message
		{
			var post = $j(this).serialize();
			var url = $j(this).attr('action');
			
			//clear textarea
			$j("#message").val('');
			
			$j.post(url,post,function(data)
			{
				if(data.indexOf('Error:')!=-1)$j("#messages-box").append("<div class='error'>"+data+"</div>");
			});
			
			//show message
			var d = new Date();
			var message_date = formatDate(d);
			addMessageToBox(message_date,window.my_nick,message_text,{message:'message',nick:'my-nick',message_text:'my-message-text'});
			//scroll messages box
		    scrollMessageBox();
		}
		
		return false;
	});
	
	//read new messages
	getNewMessages();
	var check_messages_interval = 3000; //3 seconds
	setInterval('getNewMessages()',check_messages_interval);
});