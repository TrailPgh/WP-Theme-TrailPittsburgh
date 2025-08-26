<?php
/**
 * The template for displaying comments
 */
if ( post_password_required() ) {
	return;
}
?>



<div id="comments">

<?php if ( have_comments() ) : ?>
			<h3 id="comments-title" class="p-border"><?php printf( esc_attr( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(),'dotorg' )),
			number_format_i18n( get_comments_number() ),   get_the_title(','));
			?><strong>" <?php echo  get_the_title(); ?> "</strong></h3>
            <div class="hrline"></div>

			<ol class="commentlist">
				<?php
					wp_list_comments('avatar_size=54');
				?>
			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous fl"><?php previous_comments_link( esc_html__( 'Older Comments','dotorg' ) ); ?></div>
				<div class="nav-next fr"><?php next_comments_link( esc_html__( 'Newer Comments','dotorg' ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<p class="nocomments"><?php esc_html_e( 'Comments are closed.','dotorg' ); ?></p>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php comment_form(); ?>

</div><!-- #comments -->
