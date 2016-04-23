<?if($item['hide_label']=='yes') $item['label'] = '&nbsp;';?>

<?$label_style = (in_array($item['label_position'],array('left','right'))) ? "float:".$item['label_position'].";" : ""; ?>
<?$label_style .= "text-align:".$item['label_align'].";"?>
<?if($item['label_width']) $label_style .= "width:{$item['label_width']}{$item['label_width_units']};"?>
<?$label_on_the_side = (in_array($item['label_position'],array('left','right'))) ? " label-on-the-side" : ""; ?>
<?if(stristr($item['validation'],'required')){$item['label'].=' <span class="red">*</span>';}?>
<?=form_label($item['label'],$item['html_id'],array('class'=>'desc'.$label_on_the_side,'style'=>$label_style))?>