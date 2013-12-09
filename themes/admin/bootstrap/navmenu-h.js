$j(document).ready(function(){
  $j("#navmenu-h li,#navmenu-v li").hover(
    function() { $j(this).addClass("iehover"); },
    function() { $j(this).removeClass("iehover"); }
  );
});