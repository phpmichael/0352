<script>

$j(document).ready(function(){
	
	//masks
	/*$j.mask.masks = $j.extend($j.mask.masks,{
		float_number:{ mask: '99.999999' , type:'reverse' }
	});*/
	
	$j('input:text').setMask(
		{
			attr: 'alt', // an attr to look for the mask name or the mask itself
			//mask: null, // the mask to be used on the input
			type: 'fixed', // the mask of this mask
			maxLength: -1, // the maxLength of the mask
			defaultValue: '', // the default value for this input
			textAlign: true, // to use or not to use textAlign on the input
			selectCharsOnFocus: true, //selects characters on focus of the input
			setSize: false, // sets the input size based on the length of the mask (work with fixed and reverse masks only)
			autoTab: true, // auto focus the next form element
			fixedChars : '[(),.:/ -]', // fixed chars to be used on the masks.
			onInvalid : function(c,nKey){
				if( $j(this).parent().find("span.red").length>0 ) $j(this).parent().find("span.red").text('<?=language('wrong_character')?>').show();
				else $j(this).parent().append("<span class='red'></span>");
			},
			onValid : function(){
				$j(this).parent().find("span.red").hide();
			},
			onOverflow : function(){}
		}
	);
	
});

</script>