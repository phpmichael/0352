<div align="center">
<table>
	<tr height='140' valign="bottom" style="padding:10px 0 10px 0;">
		<td class="red"><?=validation_errors()?></td>
	</tr>
	<tr>
		<td width="235" height="91" valign="top" style="padding-top:7px;padding-left:15px;background:url('<?=$BC->_getTheme(true)?>images/bglogin.jpg') no-repeat;">
			
			<?=form_open($BC->_getBaseURI()."/signin")?>
			<table>
				<tr>
					<td><img src="<?=$BC->_getTheme(true)?>images/login.gif"></td>
					<td><?=form_input("email",'')?></td>
				</tr>
				<tr>
					<td><img src="<?=$BC->_getTheme(true)?>images/pass.gif"></td>
					<td><?=form_password("password",'')?></td>
				</tr>
				<tr>
					<td colspan="2"><input type="image" src="<?=$BC->_getTheme(true)?>images/login_btn.gif" border="0" hspace="5"></td>
				</tr>
			</table>
			</form>
			
		</td>
	</tr>
</table>
</div>