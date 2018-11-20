<?php
/*
Template Name: Login Page
*/
?>
<?php if (is_front_page()) { ?>
	<?php get_template_part('home'); ?>
<?php } else { ?>
<?php
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
?>

<?php get_header(); ?>
	<div id="wrap"<?php if ($fullwidth) echo ' class="no_sidebar"'; ?>>
	<!-- Main Content-->
		<img src="<?php echo get_template_directory_uri(); ?>/images/content-top<?php if ($fullwidth) echo ('-full');?>.gif" alt="content top" class="content-wrap" />
		<div id="content">
			<!-- Start Main Window -->
			<div id="main">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="new_post entry clearfix">

					<h1 id="post-title"><?php the_title(); ?></h1>
						<div class="postcontent">
							<?php $width = (int) get_option('polished_thumbnail_width_pages');
								  $height = (int) get_option('polished_thumbnail_height_pages');
								  $classtext = 'post_img';
								  $titletext = get_the_title();

								  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext);
								  $thumb = $thumbnail["thumb"]; ?>

							<?php if($thumb <> '' && get_option('polished_page_thumbnails') == 'on') { ?>
								<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext , $width, $height, $classtext); ?>
							<?php }; ?>
							<?php the_content(); ?>
							<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Polished').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

							<div id="et-login">
								<div class='et-protected'>
									<div class='et-protected-form'>
										<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

										<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
											<p><label><span><?php esc_html_e('Username','Polished'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
											<p><label><span><?php esc_html_e('Password','Polished'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
											<input type='submit' name='submit' value='Login' class='etlogin-button' />
										</form>
									</div> <!-- .et-protected-form -->
								</div> <!-- .et-protected -->
							</div> <!-- end #et-login -->

							<div class="clear"></div>

							<?php edit_post_link(esc_html__('Edit this page','Polished')); ?>
							<div class="clear"></div>

						</div> <!-- end .post -->
				</div>
			<?php endwhile; endif; ?>
			</div>
			<!-- End Main -->

	<?php if (!$fullwidth) get_sidebar(); ?>
	<?php get_footer(); ?>
<?php } ?>