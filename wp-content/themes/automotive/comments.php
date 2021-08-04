<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','language');?></p>
	<?php
		return;
	}
?>
<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
	<h3 id="comments"><?php comments_number(__('No Comments', 'language'), __('One Comment', 'language'), __('% Comments', 'language'));?>
	</h3>
	<ol class="commentlist">
	<?php wp_list_comments('avatar_size=60'); ?>
	</ol>
 <?php else : // this is displayed if there are no comments so far ?>
	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.','language');?></p>
	<?php endif; ?>
<?php endif; ?>
<?php /* BEGIN TRACKBACK/PINGBACK CODE */ ?>
<?php global $trackbacks; ?>
<?php if ($trackbacks) : ?>
<?php $comments = $trackbacks; ?>
<div id="pingback-trackback">
<h3 id="trackbacks"><?php echo sizeof($trackbacks); ?><?php _e('Trackbacks/Pingbacks','language');?></h3>
	<ol class="pings">
	<?php foreach ($comments as $comment) : ?>
<!-- Start Your trackback Code -->
		<li <?php echo $oddcomment; ?>id="comment-<?php comment_ID() ?>">
			<cite><?php comment_author_link() ?></cite>
			<?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.','language');?></em>
			<?php endif; ?>  
 		</li>
<!-- End Your trackback Code -->
	<?php
		/* Changes every other comment to a different class */
		$oddcomment = ( empty( $oddcomment ) ) ? 'class="alt" ' : '';
	?>
	<?php endforeach; /* end for each comment */ ?>
	</ol>
</div>
<?php endif; ?>
<?php /* END TRACKBACK/PINGBACK CODE */ ?>
<?php if ( comments_open() ) : ?>
<div id="respond">
<h3><?php comment_form_title(__('Leave a reply', 'language'), __('Leave A Reply', 'language')); ?><span></span></h3>
<div class="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>
<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p><?php _e('You must be ','language');?><a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e('logged in','language');?></a> <?php _e('to post a comment.','language');?></p>
<?php else : ?>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php if ( is_user_logged_in() ) : ?>
<p><?php _e('Logged in as ','language');?><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out','language');?> &raquo;</a></p>
<?php else : ?>
<p><label for="author"><?php _e('Name*','language');?></label><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1"/></p>
<p><label for="email"><?php _e('Mail*','language');?></label><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" /></p>
<p><label for="url"><?php _e('Website','language');?></label><input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" /></p>
<?php endif; ?>
<p><textarea name="comment" id="comment" cols="70" rows="10" tabindex="4"></textarea></p>
<p ><input name="submit" id="submit-comment" type="submit"  tabindex="5" value="<?php _e('Submit Comment', 'language'); ?>" /></p>
<div style="clear:both"></div>
<?php comment_id_fields(); ?>
</p>
<?php do_action('comment_form', $post->ID); ?>
</form>
<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>