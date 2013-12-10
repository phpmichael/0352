//Open new window in browser
function openWindow(url,windowName,params)
{
	if(!params) params = 'width=700, height=780, scrollbars=1';
	window.open(url,windowName,params);
}

//Open Instant Messenger
function openImWindow(url,windowName)
{
	if(!windowName) windowName = 'im_window';
	params = 'width=500, height=600, scrollbars=1';
	window.open(url,windowName,params);
}

//Show custom dialog box
function dialog(title,text,buttons,width)
{
	//check if element with id=dialog exists
	if( $j('#dialog').length==0 )
	{
	    console.log("#dialog doesn't exist");
	    return false;
	}
    
    // set title		
	$j('#dialog').attr('title',title);
	
	//set text
	$j('#dialog').html(text);
	
	// init dialog
	$j('#dialog').dialog({
		autoOpen: false,
		width: width,
		buttons: buttons
	});
	
	// open dialog
	$j('#dialog').dialog('open');
}

//Check version of flash plugin
function getFlashVersion()
{
  // ie
  try {
    try {
      // avoid fp6 minor version lookup issues
      // see: http://blog.deconcept.com/2006/01/11/getvariable-setvariable-crash-internet-explorer-flash-6/
      var axo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash.6');
      try { axo.AllowScriptAccess = 'always'; }
      catch(e) { return '6,0,0'; }
    } catch(e) {}
    return new ActiveXObject('ShockwaveFlash.ShockwaveFlash').GetVariable('$version').replace(/\D+/g, ',').match(/^,?(.+),?$/)[1];
  // other browsers
  } catch(e) {
    try {
      if(navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin){
        return (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]).description.replace(/\D+/g, ",").match(/^,?(.+),?$/)[1];
      }
    } catch(e) {}
  }
  return '0,0,0';
}