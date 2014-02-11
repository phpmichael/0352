<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Return post's comments.
 *
 * @param string $table
 * @param integer $post_id
 * @return array
 */
function get_comments($table,$post_id)
{
	$CI =& get_instance();
	return $CI->comments_model->getTree($table,$post_id);
}

/**
 * Show comments count.
 *
 * @param string $table
 * @param integer $post_id
 * @param bool|string $zero
 * @param bool|string $one
 * @param bool|string $more
 * @return string
 */
function comments_number($table,$post_id,$zero=false,$one=false,$more=false)
{
	$number = get_comments_number($table,$post_id);

	if ( $number > 1 )
		$output = ( false === $more ) ? str_replace('%', $number,'% '.language('comments')) : str_replace('%', $number,$more);
	elseif ( $number == 0 )
		$output = ( false === $zero ) ? language('no_comments') : $zero;
	else // must be one
		$output = ( false === $one ) ? '1 '.language('comment') : $one;
		
	return $output;
}

/**
 * Return comments number.
 *
 * @param string $table
 * @param integer $post_id
 * @return integer
 */
function get_comments_number($table,$post_id)
{
	$CI =& get_instance();
	return $CI->comments_model->getCount($table,$post_id);
}

/**
 * Return link with title=author name, and href=author website.
 *
 * @param array $comment
 * @param array $params
 * @return string
 */
function comment_author_link($comment,array $params=array())
{
	$defaults = array(
		'display_author_url'=>'',
	);
	
	$params = array_merge($defaults,$params);
	
	if( $comment['comment_author_url'] ) 
	{
		if($params['display_author_url']=='no')
		{
			return $comment['comment_author'];
		}
		elseif ($params['display_author_url']=='left')
		{
			return "{$comment['comment_author']} <a href='{$comment['comment_author_url']}'>{$comment['comment_author_url']}</a>";
		}
		else return "<a href='{$comment['comment_author_url']}'>{$comment['comment_author']}</a>";
	}
	
	return $comment['comment_author'];
}

/**
 * Datetime of comment.
 *
 * @param array $comment
 * @param string $format
 * @return string
 */
function comment_time($comment,$format)
{
	return date($format,strtotime($comment['comment_date']));
}

/**
 * Return comment text.
 *
 * @param array $comment
 * @return string
 */
function comment_text($comment)
{
	return nl2br($comment['comment_content']);
}


/**
 * Show comments tree.
 *
 * @param object $view
 * @param array $comments
 * @param array $params
 */
function show_comments($view,$comments,array $params=array())
{
	$defaults = array(
		'list_class'=>'commentlist',
		'sub_level_class'=>'sub-level',
		'comment_avaiting_validation_text'=>language('comment_is_awaiting_validation'),
		'user_says_text'=>'',
		'comment_on_comment_text'=>language('comment_this'),
		'comment_time_format'=>'d/m/Y',
	);
	
	$params = array_merge($defaults,$params);
	
	if( @count($comments) )
	{
	?>
	<ul class="<?=$params['list_class']?>">
	<?
	$i=0;
	foreach ($comments as $comment)
	{
		show_comment($view,$comment,$params,$i);
		?>
			<li class='<?=$params['sub_level_class']?>'>
			<?show_comments($view,$comment['children'],$params)?>
			</li>
		<?
	}
	?>
	</ul>
	<?
	}
}

/**
 * Show one comment.
 *
 * @param object $view
 * @param array $comment
 * @param array $params
 * @param integer $i
 */
function show_comment($view,$comment,array $params=array(),&$i)
{
    $i++; 
	$oddcomment = $i%2;
	
	?>
		<li class="comment<?if($oddcomment):?> alt<?endif?>" id="comment-<?=$comment['id']?>">
		
			<a name="comment-<?=$comment['id']?>"></a>
			
			<?load_theme_view('inc/box-rate',array('post_id'=>$comment['id'],'rating'=>$comment['rating'],'already_rated'=>$comment['already_rated'],'table'=>'comments'));?>
		
			<div class="comment-author">
				<cite><?=comment_author_link($comment,$params) ?></cite><?=$params['user_says_text']?>:
			</div>
			
			<small class="commentmetadata"><?=comment_time($comment,$params['comment_time_format']) ?></small>
			
			<div id="div-comment-<?=$comment['id']?>">
			<?php if ($comment['comment_approved'] == '0'):?>
				<em><?=$params['comment_avaiting_validation_text']?></em>
			<?else:?>
				<?=comment_text($comment)?>
			<?php endif; ?>
			</div>
			
			<div class="add-comment">
				<a href="#" data-comment-id="<?=$comment['id']?>"><?=$params['comment_on_comment_text']?></a>
				<?if(userAccess('comments','edit')):?><?=anchor_base("admin/comments/edit/id/desc/0/".$comment['id'],language('edit'))?><?endif?>
			</div>
            
		</li>
	<?
}

/**
 * Show form for adding comments.
 *
 * @param string $table
 * @param integer $post_id
 * @param array $params
 */
function show_comment_form($table, $post_id, array $params=array())
{
	$defaults = array(
		'name_label'=>language('name'),
		'email_label'=>language('email'),
		'website_label'=>language('website'),
		'comment_label'=>'',
		'submit_button_text'=>language('submit')
	);
	
	$params = array_merge($defaults,$params);
	
	$customer = get_customer();
	?>
	<p class="green" id="success"></p>
    <p class="red" id="errors"></p>
	
	<form action="" method="post" id="commentform" style="display:none;">

	<p>
		<input type="text" name="comment_author" id="comment_author" value="<?=@$customer['name']?>" size="22" tabindex="1" class="commentfield" />
		<label for="comment_author"><small><?=$params['name_label']?></small></label>
	</p>
	
	<p>
		<input type="text" name="comment_author_email" id="comment_author_email" value="<?=@$customer['email']?>" size="22" tabindex="2" class="commentfield" />
		<label for="comment_author_email"><small><?=$params['email_label']?></small></label>
	</p>
	
	<p>
		<input type="text" name="comment_author_url" id="comment_author_url" value="<?=@$customer['website']?>" size="22" tabindex="3" class="commentfield" />
		<label for="comment_author_url"><small><?=$params['website_label']?></small></label>
	</p>
	
	<p>
		<textarea name="comment_content" id="comment_content" cols="50" rows="10" tabindex="4"></textarea>
		<?if($params['comment_label']):?><label for="comment_content"><small><?=$params['comment_label']?></small></label><?endif?>
	</p>

	<p>
		<input type="submit" tabindex="5" value="<?=$params['submit_button_text']?>" class="button" />
		<input type="hidden" name="post_id" value="<?=$post_id?>" />
		<input type="hidden" name="table" value="<?=$table?>" />
		<input type="hidden" name="parent_id" value="0" id="parent_id" />
		<input type="hidden" name="ca" value="0" id="ca" />
	</p>
	
	</form>
	<?
}

/**
 * Show link for adding comments.
 *
 * @param array $params
 */
function show_add_comment_link(array $params=array())
{
	$defaults = array(
		'add_comment_text'=>language('leave_a_comment'),
	);
	
	$params = array_merge($defaults,$params);
	
	?>
	<h3 id="respond"><a href="#" data-comment-id="0"><?=$params['add_comment_text']?></a><a name="add-comment"></a></h3>
	<?
}

/**
 * Check if leave comments allowed.
 *
 * @param string $table
 * @return bool
 */
function isCommentsAllowed($table)
{
    $CI =& get_instance();
    return @$CI->settings_model["comments_for_{$table}_allowed"];
}

/**
 * Check if rate allowed.
 *
 * @param string $table
 * @return bool
 */
function isRatingsAllowed($table)
{
    $CI =& get_instance();
    return @$CI->settings_model["ratings_for_{$table}_allowed"];
}