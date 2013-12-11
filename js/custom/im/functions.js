//show history messages
function showHistory(data)
{
	for(message_id in data)
	{
		d = new Date(data[message_id].seconds*1000);//make JS Date object from unix timestamp
		message_date = formatDate(d);
		message_text = data[message_id].message;
		
		if(data[message_id].to_id==recipient_id)
		    //logged user's message
			addMessageToBox(message_date,window.my_nick,message_text,{message:'message-history',nick:'my-nick',message_text:'my-message-text'});
		else 
		    //recipient's message
		    addMessageToBox(message_date,window.nick,message_text,{message:'message-history',nick:'nick',message_text:'message-text'});
	}
}

//read new messages
function getNewMessages()
{
	var url = window.get_new_messages_url;
	
	$j.getJSON(url,function(data)
	{
        if(data.indexOf('Error:')!=-1)$j("#messages-box").append("<div class='error'>"+data+"</div>");
		else if(data.length !=0 )
        {
    		for(message_id in data)
        	{
        		d = new Date(data[message_id].seconds*1000);//make JS Date object from unix timestamp
        		message_date = formatDate(d);
        		message_text = data[message_id].message;
        		
        		//recipient's message
        		addMessageToBox(message_date,window.nick,message_text,{message:'message',nick:'nick',message_text:'message-text'});
        		//scroll messages box
        		scrollMessageBox();
        	}
        }
    });
}

//return date in format dd/mm/YYYY HH:ii
function formatDate(d)
{
	var day = d.getDate();
	var month = d.getMonth()+1; if(month<=9) month = '0'+month;
	var year = d.getFullYear();
	var hours = d.getHours(); 
	var minutes = d.getMinutes(); if(minutes<=9) minutes = '0'+minutes;
	return (day+'/'+month+'/'+year+' '+hours+':'+minutes);
}

//Make scrolling
function scrollMessageBox()
{
	$j("#messages-box").animate({scrollTop:$j("#messages-box").attr('scrollHeight')});
}

//Add new message
function addMessageToBox(message_date,nick,message_text,css_classes)
{
	message_text = message_text.replace(/\n/g,'<br />');
	$j("#messages-box").append("<div class='"+css_classes.message+"'><span class='date'>["+message_date+"]</span><span class='"+css_classes.nick+"'>"+nick+"</span>:<span class='"+css_classes.message_text+"'>"+message_text+"</span></div>");
}