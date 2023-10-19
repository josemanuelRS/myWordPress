<!doctype html>
<html lang="en">
	<head>
	<!-- Required meta tags -->

	<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-M34CX3H2');
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<!-- End Google Tag Manager -->
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>MyWordpress</title>
	<?php wp_head(); ?>
	</head>
	<body>

	<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M34CX3H2"
			height="0" width="0" style="display:none;visibility:hidden"></iframe>
		</noscript>
	<!-- End Google Tag Manager (noscript) -->

	<!-- navbar -->
		<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
			<div class="container" id="navbar">
				<a class="navbar-brand" href="/wordpress"><img class="img-fluid" style="max-width: 77px;" src="<?php bloginfo('template_directory'); ?>/assets/images/logo.png" /></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
				<a class="nav-link" href="/wordpress">Posts</a>
				</li>
				<li class="nav-item">
				<a class="nav-link" href="/wordpress/mitarbeiter">Employees</a>
				</li>
				<li class="nav-item">
				<a class="nav-link" href="/wordpress/slider">Slider</a>
				</li>
				
				<?php
					wp_nav_menu(
						array(
							'menu' => 'primary',
							'container' => '',
							'theme_location' => 'primary',
							'items_wrap' => '<div class="collapse navbar-collapse" style="margin-left:25px;" id="navbarNavDarkDropdown">
															 <ul class="navbar-nav">
        												<li class="nav-item dropdown">
															 		<a class="nav-link dropdown-toggle" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu
															 		</a>
																<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton">'
						)
					);

					global $wpdb;
					$menu_elements = $wpdb->get_results("SELECT * FROM wp_menuoptionen");

					if ($menu_elements) {
					// Iterates through the database items and displays each one as a menu link
						foreach ($menu_elements as $element) {
							echo '<li><a class="dropdown-item" href="' . esc_url($element->url) . '">' . esc_html($element->text_link) . '</a></li>';
						}
					}
					echo '</ul></li></ul></div>';
				?>
				</ul>
			</div>
		</div>
		</nav>
	<!-- fin navbar -->

	<div class="container-fluid" style="max-width: 75%;">



	
