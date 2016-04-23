<?$div_style = "text-align:".$item['align'].";"?>

<?if($item['label_width']) $div_style .= "width:".(100-$item['label_width'])."{$item['label_width_units']};"?>

<div style="<?=$div_style?>" <?if(in_array($item['label_position'],array('left','right'))):?>class="input-on-the-side"<?endif?>>