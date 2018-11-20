<?php
	$arr = array();
	$i=1;

	$width = 177;
	$height = 177;

	$width2 = 35;
	$height2 = 35;

	$featured_cat = get_option('polished_feat_cat');
	$featured_num = (int) get_option('polished_featured_num');

	if (get_option('polished_use_pages') == 'false') query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
	else {
		global $pages_number;
		if (get_option('polished_feat_pages') <> '') $featured_num = count(get_option('polished_feat_pages'));
		else $featured_num = $pages_number;

		$et_featured_pages_args = array(
			'post_type' => 'page',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => (int) $featured_num,
		);

		if ( is_array( et_get_option( 'polished_feat_pages', '', 'page' ) ) )
			$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'polished_feat_pages', '', 'page' ) );

		query_posts( $et_featured_pages_args );
	};

	while (have_posts()) : the_post();

		$arr[$i]["title"] = truncate_title(32,false);
		$arr[$i]["title2"] = truncate_title(25,false);
		$arr[$i]["fulltitle"] = truncate_title(250,false);
		$arr[$i]["excerpt"] = truncate_post(345,false);
		$arr[$i]["permalink"] = get_permalink();
		$arr[$i]["postinfo"] = esc_html__("Posted by", "Polished")." ". get_the_author_meta('display_name') . esc_html__(' on ','Polished') . get_the_time(get_option('polished_date_format'));

		$arr[$i]["thumbnail"] = get_thumbnail($width,$height,'featured_img',$arr[$i]["fulltitle"]);
		$arr[$i]["thumb"] = $arr[$i]["thumbnail"]["thumb"];
		$arr[$i]["use_timthumb"] = $arr[$i]["thumbnail"]["use_timthumb"];

		$arr[$i]["thumbnail2"] = get_thumbnail($width2,$height2,'',$arr[$i]["fulltitle"]);
		$arr[$i]["thumb2"] = $arr[$i]["thumbnail2"]["thumb"];

		$arr[$i]['post_id'] = (int) get_the_ID();

		$i++;
	endwhile; wp_reset_query();	?>

	<!-- Start Featured -->
		<div id="featured">
			<div id="left_arrow"><a href="#" id="previous"><img src="<?php echo get_template_directory_uri(); ?>/images/fleft_arrow.png" width="32" height="70" alt="Featured Previous"/></a></div>

			<!-- Featured Content -->
			<div id="featured_content">

				<!-- Featured Articles -->
				<div id="spotlight">
					<?php if ($featured_num > 4) $featured_num=4;
					for ($i = 1; $i <= $featured_num; $i++) { ?>
						<div class="slide">
							<h1><?php echo esc_html($arr[$i]["title"]); ?></h1>
							<br class="clear" />
						<?php
							print_thumbnail( array(
								'thumbnail' 	=> $arr[$i]["thumbnail"]["thumb"],
								'use_timthumb' 	=> $arr[$i]["thumbnail"]["use_timthumb"],
								'alttext'		=> $arr[$i]["fulltitle"],
								'width'			=> (int) $width,
								'height'		=> (int) $height,
								'class'			=> 'featured_img',
								'et_post_id'	=> $arr[$i]['post_id'],
							) );
						?>
							<?php echo $arr[$i]["excerpt"]; ?>

							<span class="readmore_g"><a href="<?php echo esc_url($arr[$i]["permalink"]); ?>"> <?php esc_html_e('Read More','Polished') ?></a></span>
						</div>
					<?php }; ?>
				</div>
				<!-- End Featured Articles -->

				<!-- Featured Menu -->
				<div id="f_menu">
					<?php for ($i = 1; $i <= $featured_num; $i++) { ?>
						<div class="featitem<?php if ($i==1) echo ' active'; if ($i==$featured_num) echo ' last'; ?>">
						<?php
							print_thumbnail( array(
								'thumbnail' 	=> $arr[$i]["thumb2"],
								'use_timthumb' 	=> $arr[$i]["use_timthumb"],
								'alttext'		=> $arr[$i]["fulltitle"],
								'width'			=> (int) $width2,
								'height'		=> (int) $height2,
								'et_post_id'	=> $arr[$i]['post_id'],
							) );
						?>
							<h2><?php echo $arr[$i]["title2"]; ?></h2>
							<span class="meta"><?php echo $arr[$i]["postinfo"]; ?></span>
							<span class="order"><?php echo $i; ?></span>
						</div>
					<?php }; ?>
				</div>
				<!-- End Featured Menu -->
			</div>
			<!-- End Featured Content -->

			<div id="right_arrow"><a href="#" id="next"><img src="<?php echo get_template_directory_uri(); ?>/images/fright_arrow.png" width="32" height="70" alt="Featured Next"/></a></div>
		</div>
		<!-- End Featured -->