<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.",'avisio'); ?></p>
	<?php
		return;
	}
?><!--wordpress needs all of the code above do not delete but you can edit the sentence-->

<!-- You can start editing here. -->
<!--if there is one comment-->
<?php if ( have_comments() ) : ?><!--you need the id comments for the links to the comments-->
	<h4 class="heading" id="comments"><?php comments_number(__('No Responses','avisio'), __('One Response','avisio'), __('% Responses','avisio') );?> to &#8220;<?php the_title(); ?>&#8221;</h4>

	<ol class="commentlist"><!--one comment-->
	<?php wp_list_comments('callback=custom_comments'); ?>
	<!--end of one comment if you would like to seperate comments and pings please search for english tutorials-->
	</ol>
<!--comments navi-->
<div class="comment_nav">
	<?php previous_comments_link("<span class='comment_prev advancedlink'>&laquo; ".__('Older Comments','avisio')."</span>") ?>
	<?php next_comments_link("<span class='comment_next advancedlink'>".__('Newer Comments','avisio')." &raquo;</span>") ?>
</div>
	
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
<span class="meta" id="comments"><?php comments_number(__('No Responses','avisio'), __('One Response','avisio'), __('% Responses','avisio') );?> 
<?php _e('to','avisio'); ?> &#8220;<?php the_title(); ?>&#8221;</span>    
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<span class="meta"><?php _e('Comments are closed.','avisio'); ?></span>

	<?php endif; ?>
<?php endif; ?><!--end of comments-->

<!--beginn of the comments form-->
<?php if ('open' == $post->comment_status) : ?>

<div id="respond"><!--you need div  id response for threaded comments-->

<?php comment_form_title( '<h3 id="reply_headding">'.__('Leave a Reply','avisio').'</h3>', '<h3>'.__('Leave a Reply to %s','avisio').'</h3>'); ?>



<!--if registration is required-->
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>
<?php _e('You must be','avisio'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">
<?php _e('logged in','avisio'); ?>
</a> 
<?php _e('to post a comment.','avisio'); ?>
</p>

<?php else : ?>
<!--begin of the comment form read and understand -->
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<div class='personal_data'>
<?php if ( $user_ID ) : ?>

<p>
<?php _e('Logged in as','avisio'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out','avisio'); ?> &raquo;</a></p>

<?php else : 

if ($comment_author == '') $comment_author = __('Name');
if ($comment_author_email == '') $comment_author_email = __('E-Mail Adress');
if ($comment_author_url == '') $comment_author_url = __('Website');

?>

<p><input type="text" name="author" class="text_input" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1"  />
<label for="author"><small><?php _e('Name','avisio');  if ($req) echo " (required)"; ?></small></label></p>

<p><input type="text" name="email" class="text_input" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><?php _e('Mail (will not be published)','avisio');  if ($req) echo " (required)"; ?></small></label></p>

<p><input type="text" name="url" class="text_input" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><?php _e('Website','avisio'); ?></small></label></p>

<?php endif; ?>

</div>
<div class='message_data'>
<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->

<p><textarea name="comment" id="comment" cols="100%" rows="10" class='text_area' tabindex="4"></textarea></p>
</div><p><input name="submit" class="button" type="submit" id="submit" tabindex="5" value="Submit" /><?php cancel_comment_reply_link(__("Cancel Reply",'avisio')); ?><!--to cancel the comment link or not-->
<?php comment_id_fields(); ?><!--this is necessary because wp must know which comment to which article-->

<?php do_action('comment_form', $post->ID); ?><!--some plugins needs this hook--></p>
</form>


<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>