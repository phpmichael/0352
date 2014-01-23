<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo -->
	<div id="login-errors" class="red">
		<?=validation_errors()?>
	</div>
	<!-- end logo -->
	
	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->
	<div id="loginbox">
	
	<?=form_open($BC->_getBaseURI()."/signin")?>
	<!--  start login-inner -->
	<div id="login-inner">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>E-mail</th>
			<td><input name="email" type="text"  class="login-inp" /></td>
		</tr>
		<tr>
			<th>Password</th>
			<td><input name="password" type="password" value="" class="login-inp" /></td>
		</tr>
		<!--
		<tr>
			<th></th>
			<td valign="top"><input type="checkbox" class="checkbox-size" id="login-check" /><label for="login-check">Remember me</label></td>
		</tr>
		-->
		<tr>
			<th></th>
			<td><input type="submit" class="submit-login"  /></td>
		</tr>
		</table>
	</div>
 	<!--  end login-inner -->
 	</form>
 	
	<div class="clear"></div>
	<a href="" class="forgot-pwd">Forgot Password?</a>
 </div>
 <!--  end loginbox -->
 
	<!--  start forgotbox ................................................................................... -->
	<div id="forgotbox">
		<div id="forgotbox-text">Please send us your email and we'll reset your password.</div>
		<!--  start forgot-inner -->
		<div id="forgot-inner">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Email address:</th>
			<td><input type="text" value=""   class="login-inp" /></td>
		</tr>
		<tr>
			<th> </th>
			<td><input type="button" class="submit-login"  /></td>
		</tr>
		</table>
		</div>
		<!--  end forgot-inner -->
		<div class="clear"></div>
		<a href="" class="back-login">Back to login</a>
	</div>
	<!--  end forgotbox -->

</div>
<!-- End: login-holder -->

<script>
$j(document).ready(function () {
	$j(".forgot-pwd").click(function () {
    	$j("#loginbox").hide();
    	$j("#forgotbox").show();
    	return false;
	});
});

$j(document).ready(function () {
	$j(".back-login").click(function () {
    	$j("#loginbox").show();
    	$j("#forgotbox").hide();
    	return false;
	});
});
</script>