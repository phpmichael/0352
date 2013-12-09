$j(document).ready(function()
{$j("#contact_form :input[type='submit']").click(function()
{$j.post(appPackages.contact_us.form_action,$j("#contact_form").serialize(),function(data)
{if(data=='success')
{$j("#success").html(appPackages.contact_us.messages.your_message_sent);$j("#errors").hide();$j("#contact_form").hide();}
else $j("#errors").html(data);});return false;});});
