<!doctype html>
<html <?php language_attributes(); ?> class="no-js preload">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php bloginfo('description'); ?>">

	<link rel="icon"
      type="image/png"
      href="<?php echo get_template_directory_uri(); ?>/img/favicon.png">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,700,400italic,700italic|Droid+Serif:400,400italic,700,700italic' rel='stylesheet' type='text/css'>

	<?php wp_head(); ?>

	<?php
		/*
			Site Variables via Options page
			used in body and header styling
		*/

		$headerBgColor = '';
		$bgImage = '';
		$siteBgColor = '';
		$siteBgImg = '';
		if(get_field('header_bg_color', 'option')){
			// $headerBg = 'style="background-color:'. get_field('header_bg_color', 'option') .';"';
			$headerBgColor = get_field('header_bg_color', 'option');
		}
		if(get_field('site_bg_color', 'option')){
			$siteBgColor = get_field('site_bg_color', 'option');
		}
		if(get_field('site_bg_image', 'option')){
			$siteBgImg = get_field('site_bg_image', 'option')[url];
		}
		$headerTextColor = '';
		$heroTextColor ='';
		if(get_field('header_text_color', 'option')){
			$headerTextColor = 'style="color:'. get_field('header_text_color', 'option') .';"';
			$heroTextColor = get_field('header_text_color', 'option');
		}

		// Audio Player
		$player = '';
		$playerLocation = '';
		$playerTitle = 'saf';
		if(get_field('audio_player', 'option')){
			$player .= get_field('audio_player', 'option');
			if(get_field('audio_player_location', 'option')){
				$playerLocation = get_field('audio_player_location', 'option');
			}
			if(get_field('audio_player_title', 'option')){
				$playerTitle = get_field('audio_player_title', 'option');
			}
		}
	?>

	<?php
		// Set up backgorund styles for body
		$siteBgStyle = '';
		if($siteBgImg || $siteBgColor){
			$color = '';
			if($siteBgColor){
				$color = $siteBgColor;
			}
			$siteBgStyle = 'style="background:url('. $siteBgImg .') repeat center center '. $color .'"';
		}
	?>

</head>
	<body <?php body_class(); ?> <?=$siteBgStyle?>>

		<div class="loading-animation">
			<?php include('loading-animation.php'); ?>
		</div>

		<nav id="mobile-menu" role="navigation" class="visible-xs">
			<?php/*
			wp_nav_menu(
			array(
				'menu'            => 'Mobile',
				'container'       => '',
				'container_class' => '',
				'container_id'    => '',
				'menu_class'      => 'nav',
				'menu_id'         => '',
				'echo'            => true,
				'fallback_cb'     => '',
				'before'          => '',
				'after'           => '',
				'link_before'     => '',
				'link_after'      => '',
				'items_wrap'      => my_nav_wrap(),
				'depth'           => 0,
				'walker'          => ''
				)
			);*/
			?>
		</nav>

		<!-- wrapper -->
		<div id="wrapper" class="wrapper">


			<?php if($headerBgColor): ?>
				<style>
					.site-header:before {
						content: "";
				    position: absolute;
				    top: 0;
				    left: 0;
				    right: 0;
				    bottom: 0;
				    background: <?=$headerBgColor?>;
				    box-shadow: 0 0 2em 1.5em <?=$headerBgColor?>;
				    opacity: 0.6;
				    transform: translateY(-1.5em);
					}
					<?php if($heroTextColor): ?>
						.header-text {
							color:<?=$heroTextColor?>;
						}
					<?php endif; ?>
				</style>
			<?php endif; ?>

			<!-- header -->
			<header class="site-header clear" role="banner">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-24">
							<?php
								if(get_field('logo_type', 'option') == 'image' && get_field('header_logo', 'option')):
									$logo = get_field('header_logo', 'option')[sizes][medium];
							?>
								<a href="<?php echo get_site_url(); ?>">
									<img class="header-logo" src="<?=$logo?>">
								</a>
							<?php else: ?>
								<a href="<?php echo get_site_url(); ?>" <?=$headerTextColor?>>
									<h1 class="h4 site-title" <?=$headerTextColor?>><?php bloginfo('name'); ?></h1>
								</a>
							<?php endif; ?>
							<!-- nav -->

							<nav id="main-nav" role="navigation" class="force-right-xs">
									<?php if (have_posts()): while (have_posts()) : the_post(); ?>

										<?php
											// check if the flexible content field has rows of data
											if( have_rows('page_sections') ):
												while ( have_rows('page_sections') ) : the_row();
												if(get_sub_field('include_in_nav')):

													$id = '';
													$text = '';
													if(get_sub_field('nav_link_text')){
														$text = get_sub_field('nav_link_text');
														$id = strtolower(str_replace(' ', '', get_sub_field('nav_link_text')));
													} else {
														$text = get_sub_field('title');
														$id = strtolower(str_replace(' ', '', $text));
													}
													?>

													<a class="h5 smooth-scroll" href="#<?=$id?>" <?=$headerTextColor?>><?=$text?></a>

										<?php
													endif;
												endwhile;
											endif;
										?>

										<?php
											// check for social icons
											if( have_rows('social_icons', 'options') ):
												while ( have_rows('social_icons', 'options') ) : the_row();
												if(get_sub_field('icon_name') && get_sub_field('icon_link')):
													$iconName = get_sub_field('icon_name');
													$iconLink = get_sub_field('icon_link');
										?>
													<a class="h5" href="<?=$iconLink?>" target="_blank"><span class="fa <?=$iconName?>"></span></a>
										<?php
													endif;
												endwhile;
											endif;
										?>
										<!-- <a class="h5" href="https://www.facebook.com/crackmammoth" target="_blank"><span class="fa fa-facebook"></span></a>
										<a class="h5" href="https://soundcloud.com/crack-mammoth" target="_blank"><span class="fa fa-soundcloud"></span></a> -->
									<?php endwhile; endif; ?>

							</nav>

							<!-- embed player if exists -->
							<?php if($player): ?>
								<div class="audio-player <?=$playerLocation?>">
									<?php if($playerTitle): ?>
										<div class="audio-player__title mb1" <?=$headerTextColor?>>
											<?=$playerTitle?>
										</div>
									<?php endif; ?>
									<?=$player?>
								</div>
							<?php endif; ?>

							<!-- /nav -->
						</div>
					</div>
				</div>
			</header>
			<!-- /header -->


			<main id="main" role="main">
				<?php if(get_field('has_featured_image') && get_field('featured_image')):
					$bg = 'background:url('. get_field('featured_image')[sizes][large] .') no-repeat center center; background-size:cover;';
				?>

						<div class="container-fluid">
							<div class="row">
								<div class="col-sm-24 header-featured-image-wrap">
									<div class="header-featured-image">
										<div class="absolute-fill" style="<?=$bg?>" data-top="transform:translateY(0px);" data-top-bottom="transform:translateY(250px);"></div>
										<?php
											if(get_field('header_text')):
												$layout = '';
												if(get_field('text_layout')){
													$layout = get_field('text_layout');
												}
										?>
										<div class="header-text__padding" data-top="transform:translateY(0px);" data-top-bottom="transform:translateY(150px);">

												<div class="header-text wysiwyg sm-ab50-<?=$layout?>">
													<?php echo get_field('header_text'); ?>
												</div>

										</div>
									<?php endif; ?>

									</div>
								</div>
							</div>
						</div>
				<?php endif; ?>
