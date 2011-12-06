<?php

function custom_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>">
      <div class="gravatar">
      	<?php echo get_avatar($comment,$size='60',$default='' ); ?>
      </div>
      <div class='comment_content'>
	  <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      <?php printf(__('<cite class="author_name heading">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
      <?php edit_comment_link(__('(Edit)'),'  ','') ?>
      <div class="comment-meta commentmetadata">
      <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a>
      </div>
	  <div class='comment_text'>
      <?php comment_text() ?>
      <?php if ($comment->comment_approved == '0') : ?>
        <br /> <em><?php _e('Your comment is awaiting moderation.','avisio') ?></em>
         
      <?php endif; ?>
	  </div>

      </div>
     </div>
<?php
        }
