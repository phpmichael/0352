<h3><?=language('contact_information')?></h3>

<table class="fields_list">
<tr>
	<td><?=language('name')?>: </td>
	<td><?=$post_owner['name']?></td>
</tr>
<tr>
	<td><?=language('phone')?>: </td>
	<td><?=$post_owner['phone']?></td>
</tr>
<tr>
	<td><?=language('phone')?>: </td>
	<td><?=$post_owner['phone2']?></td>
</tr>
<tr>
	<td>Website (URL):</td>
	<td><?=$post_owner['website']?></td>
</tr>
<tr>
	<td><?=language('email')?>: </td>
	<td><?=str_replace("@",img($BC->_getTheme().'images/emailicon.jpg'),$post_owner['email'])?></td>
</tr>
<tr>
	<td colspan="2"><a href="javascript:void(0)" onclick="openImWindow('<?=site_url($BC->_getBaseURL().'im/index/'.$post_owner['id'])?>')"><?=language('send_message')?></a></td>
</tr>
</table>