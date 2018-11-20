<?php get_header(); ?>

	<div id="wrap">
	<!-- Main Content-->
		<img src="<?php echo get_template_directory_uri(); ?>/images/content-top.gif" alt="content top" class="content-wrap" />
		<div id="content">
			<!-- Start Main Window -->
			<div id="main">
				<?php get_template_part('includes/entry'); ?>
			</div>
			<!-- End Main -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>