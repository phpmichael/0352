$j(document).ready(function()
{$j(".request-call").click(function(){var url=appPackages.request_call.content_url;title=appPackages.request_call.title;$j.get(url,{},function(response){text=response;buttons={"Submit":function(){$j.post(appPackages.request_call.form_action,$j("#request_call_form").serialize(),function(data)
{if(data=='success')
{$j("#request_call .success").html(appPackages.request_call.messages.sent);$j("#request_call .errors").hide();$j("#request_call_form").hide();}
else $j("#request_call .errors").html(data);});return false;},"Close":function(){$j(this).dialog("close");}}
dialog(title,text,buttons,320);});});});
