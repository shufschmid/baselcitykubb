<?php
/*
Plugin Name: Morph, by Bonfire 
Plugin URI: http://bonfirethemes.com/
Description: A Fly-Out Menu for WordPress. Customize under Settings > Morph plugin. Customize colors under Appearance > Customize.
Version: 1.2
Author: Bonfire Themes
Author URI: http://bonfirethemes.com/
License: GPL2
*/


	//
	// CREATE THE SETTINGS PAGE (for WordPress backend, Settings > Morph plugin)
	//
	
	/* create "Settings" link on plugins page */
	function bonfire_morph_settings_link($links) { 
		$settings_link = '<a href="options-general.php?page=morph-by-bonfire/morph.php">Settings</a>'; 
		array_unshift($links, $settings_link); 
		return $links; 
	}
	$plugin = plugin_basename(__FILE__); 
	add_filter("plugin_action_links_$plugin", 'bonfire_morph_settings_link' );

	/* create the "Settings > Morph plugin" menu item */
	function bonfire_morph_admin_menu() {
		add_submenu_page('options-general.php', 'Morph Plugin Settings', 'Morph plugin', 'administrator', __FILE__, 'bonfire_morph_page');
	}
	
	/* create the actual settings page */
	function bonfire_morph_page() {
		if ( isset ($_POST['update_bonfire_morph']) == 'true' ) { bonfire_morph_update(); }
	?>

		<div class="wrap">
			<br>
			<h2>Morph, by Bonfire</h2>
			<strong>Psst!</strong> Morph's color options can be changed under <strong>Appearance > Customize > Morph Plugin Colors</strong>

			<br>
			<br>
			<strong>Jump to:</strong>
			<a href="#menubutton">Menu button</a> | 
			<a href="#general-options">General options</a> | 
			<a href="#heading-options">Heading options</a> | 
			<a href="#hide-at-certain-width-resolution">Hide at certain width/resolution</a>

			<form method="POST" action="">
				<input type="hidden" name="update_bonfire_morph" value="true" />

				<br><hr><br>
				
				<!-- BEGIN MENU BUTTON OPTIONS -->
				<div id="menubutton"></div>
				<br>
				<br>
				<h2>Menu button</h2>
				<table class="form-table">
					<!-- BEGIN MENU BUTTON STYLE -->
					<tr valign="top">
					<th scope="row">Menu button style:</th>
					<td>
					<?php $morph_menu_button_style = get_option('bonfire_morph_menu_button_style'); ?>
					<label><input value="morphthreelines" type="radio" name="morph_menu_button_style" <?php if ($morph_menu_button_style=='morphthreelines') { echo 'checked'; } ?>> 3 lines (traditional hamburger menu)</label><br>
					<label><input value="morphthreelinesalt" type="radio" name="morph_menu_button_style" <?php if ($morph_menu_button_style=='morphthreelinesalt') { echo 'checked'; } ?>> 3 lines (alternate hamburger menu)</label><br>
					<label><input value="morphfourlines" type="radio" name="morph_menu_button_style" <?php if ($morph_menu_button_style=='morphfourlines') { echo 'checked'; } ?>> 4 lines (alternate)</label><br>
					</td>
					</tr>
					<!-- END MENU BUTTON STYLE -->
					
					<!-- BEGIN MENU BUTTON ANIMATION -->
					<tr valign="top">
					<th scope="row">Menu button animation:</th>
					<td>
					<?php $morph_button_animation = get_option('bonfire_morph_button_animation'); ?>
					<label><input value="morphnoanimation" type="radio" name="morph_button_animation" <?php if ($morph_button_animation=='morphnoanimation') { echo 'checked'; } ?>> No animation</label><br>
					<label><input value="morphminusanimation" type="radio" name="morph_button_animation" <?php if ($morph_button_animation=='morphminusanimation') { echo 'checked'; } ?>> Minus sign</label><br>
					<label><input value="morphxanimation" type="radio" name="morph_button_animation" <?php if ($morph_button_animation=='morphxanimation') { echo 'checked'; } ?>> X sign</label><br>
					</td>
					</tr>
					<!-- END MENU BUTTON ANIMATION -->
					
					<!-- BEGIN MENU BUTTON SPEED -->
					<tr valign="top">
					<th scope="row">Menu button animation speed:</th>
					<td>
					<input style="width:45px;height:35px;" type="text" name="morph_menu_button_speed" id="morph_menu_button_speed" value="<?php echo get_option('bonfire_morph_menu_button_speed'); ?>"/> seconds
					<br> Enter custom menu button animation speed (in seconds). Example: 0.5. If left empty, defaults to 0.25
					</td>
					</tr>
					<!-- END MENU BUTTON SPEED -->
				</table>
				<!-- END MENU BUTTON OPTIONS -->

				<br><hr><br>

				<!-- BEGIN GENERAL OPTIONS -->
				<div id="general-options"></div>
				<br>
				<br>
				<h2>General options</h2>
				<table class="form-table">
					<!-- BEGIN ABSOLUTE POSITIONING -->
					<tr valign="top">
					<th scope="row">Absolute/fixed positioning:</th>
					<td>
					<label><input type="checkbox" name="morph_absolute_position" id="morph_absolute_position" <?php echo get_option('bonfire_morph_absolute_position'); ?> /> Absolute positioning (main menu button will leave the screen when scrolled).
					<br>If unticked, menu button will have fixed positioning and will remain at the top at all times.</label><br>
					</td>
					</tr>
					<!-- END ABSOLUTE POSITIONING -->

					<!-- BEGIN HIDE MAIN MENU BUTTON -->
					<tr valign="top">
					<th scope="row">Hide main menu button?:</th>
					<td>
					<label><input type="checkbox" name="morph_hide_main_menu_button" id="morph_hide_main_menu_button" <?php echo get_option('bonfire_morph_hide_main_menu_button'); ?> /> Hide main menu button. Useful if you'd like to use a custom element as the menu activator (in this case give it the "morph-main-menu-activator" class).</label><br>
					</td>
					</tr>
					<!-- END HIDE MAIN MENU BUTTON -->
					
					<!-- BEGIN HIDE SEARCH -->
					<tr valign="top">
					<th scope="row">Hide search?:</th>
					<td>
					<label><input type="checkbox" name="morph_hide_search" id="morph_hide_search" <?php echo get_option('bonfire_morph_hide_search'); ?> /> Hide search button.</label><br>
					</td>
					</tr>
					<!-- END HIDE SEARCH -->
					
					<!-- BEGIN HIDE SECONDARY MENU -->
					<tr valign="top">
					<th scope="row">Hide secondary menu?:</th>
					<td>
					<label><input type="checkbox" name="morph_hide_secondary_menu" id="morph_hide_secondary_menu" <?php echo get_option('bonfire_morph_hide_secondary_menu'); ?> /> Hide secondary menu button.</label><br>
					</td>
					</tr>
					<!-- END HIDE SECONDARY MENU -->

					<!-- BEGIN BACKGROUND OVERLAY OPACITY -->
					<tr valign="top">
					<th scope="row">Background overlay opacity:</th>
					<td>
					<input style="width:45px;height:35px;" type="text" name="morph_background_overlay_opacity" id="morph_background_overlay_opacity" value="<?php echo get_option('bonfire_morph_background_overlay_opacity'); ?>"/>
					<br> Enter custom background overlay opacity. From 0-1 (example: 0.5) If left empty, defaults to 0.3
					</td>
					</tr>
					<!-- END BACKGROUND OVERLAY OPACITY -->
					
					<!-- BEGIN DON'T LOAD FONTAWESOME -->
					<tr valign="top">
					<th scope="row">Don't load FontAwesome:</th>
					<td>
					<label><input type="checkbox" name="morph_fa_no_load" id="morph_fa_no_load" <?php echo get_option('bonfire_morph_fa_no_load'); ?> /> Don't load the FontAwesome icon set.</label><br>
					(useful if you don't use any icons with your menu items, or if your theme already loads FontAwesome).
					</td>
					</tr>
					<!-- END DON'T LOAD FONTAWESOME -->
				</table>
				<!-- END GENERAL OPTIONS -->
				
				<br><hr><br>

				<!-- BEGIN HEADING OPTIONS -->
				<div id="heading-options"></div>
				<br>
				<br>
				<h2>Heading options</h2>
				<table class="form-table">
					<!-- BEGIN HEADING TEXT -->
					<tr valign="top">
					<th scope="row">Heading text:</th>
					<td>
					<input style="width:100%;" type="text" name="morph_heading_text" id="morph_heading_text" value="<?php echo stripslashes(get_option('bonfire_morph_heading_text')); ?>"/>
					<br> To add heading text to the slide-out, enter it in the field above.
					</td>
					</tr>
					<!-- END HEADING TEXT -->
					
					<!-- BEGIN SUBHEADING TEXT -->
					<tr valign="top">
					<th scope="row">Sub-heading text:</th>
					<td>
					<input style="width:100%;" type="text" name="morph_subheading_text" id="morph_subheading_text" value="<?php echo stripslashes(get_option('bonfire_morph_subheading_text')); ?>"/>
					<br> To add sub-heading text to the slide-out, enter it in the field above.
					</td>
					</tr>
					<!-- END SUBHEADING TEXT -->
					
					<!-- BEGIN CUSTOM HEADING HEIGHT -->
					<tr valign="top">
					<th scope="row">Custom heading height:</th>
					<td>
					<label><input style="width:45px;height:35px;" type="text" name="morph_heading_height" id="morph_heading_height" value="<?php echo get_option('bonfire_morph_heading_height'); ?>"/>px
					<br> Enter custom height for heading. If left empty, defaults to 200px</label><br>
					</td>
					</tr>
					<!-- END CUSTOM HEADING HEIGHT -->
					
					<!-- BEGIN HEADING OVERLAY OPACITY -->
					<tr valign="top">
					<th scope="row">Heading overlay opacity:</th>
					<td>
					<input style="width:45px;height:35px;" type="text" name="morph_heading_overlay" id="morph_heading_overlay" value="<?php echo get_option('bonfire_morph_heading_overlay'); ?>"/>
					<br> Enter custom opacity for heading overlay color. From 0-1 (example: 0.5) If left empty, defaults to 0.2
					</td>
					</tr>
					<!-- END HEADING OVERLAY OPACITY -->
					
					<!-- BEGIN HEADING IMAGE -->
					<tr valign="top">
					<th scope="row">Heading image:</th>
					<td>
					<input style="width:100%;" type="text" name="morph_heading_image" id="morph_heading_image" value="<?php echo get_option('bonfire_morph_heading_image'); ?>"/>
					<br> To use a background image in the header, enter its URL in the field above.
					</td>
					</tr>
					<!-- END HEADING IMAGE -->
					
					<!-- BEGIN BACKGROUND PATTERN -->
					<tr valign="top">
					<th scope="row">Pattern image:</th>
					<td>
					<label><input type="checkbox" name="morph_heading_image_pattern" id="morph_heading_image_pattern" <?php echo get_option('bonfire_morph_heading_image_pattern'); ?> /> Tick this is if you wish the above image to be shown as a pattern.
					<br>If unchecked, image will be shown in full-size 'cover' style.</label><br>
					</td>
					</tr>
					<!-- END BACKGROUND PATTERN -->
				</table>
				<!-- END HEADING OPTIONS -->

				<br><hr><br>

				<!-- BEGIN HIDE BETWEEN RESOLUTIONS -->
				<div id="hide-at-certain-width-resolution"></div>
				<br>
				<br>
				<h2>Hide at certain width/resolution</h2>
				<table class="form-table">
					<tr valign="top">
					<th scope="row">Hide at certain width/resolution:</th>
					<td>
					Hide Morph menu if browser width or screen resolution is between <input style="width:50px;" type="text" name="morph_smaller_than" id="morph_smaller_than" value="<?php echo get_option('bonfire_morph_smaller_than'); ?>"/> and <input style="width:50px;" type="text" name="morph_larger_than" id="morph_larger_than" value="<?php echo get_option('bonfire_morph_larger_than'); ?>"/> pixels (fill both fields).
					<br><strong>Example:</strong> if you'd like to show morph on desktop only, then enter the values as 0 and 500. If fields are empty, morph will be visible at all browser widths and resolutions.
					</td>
					</tr>
				</table>
				<!-- END HIDE BETWEEN RESOLUTIONS -->

				<br><hr><br>

				<!-- BEGIN 'SAVE OPTIONS' BUTTON -->	
				<p><input type="submit" name="search" value="Save Options" class="button button-primary" /></p>
				<!-- BEGIN 'SAVE OPTIONS' BUTTON -->	

			</form>

		</div>
	<?php }
	function bonfire_morph_update() {

		/* menu button style */
		if ( isset ($_POST['morph_menu_button_style']) == 'true' ) {
		update_option('bonfire_morph_menu_button_style', $_POST['morph_menu_button_style']); }
		/* menu button animation */
		if ( isset ($_POST['morph_button_animation']) == 'true' ) {
		update_option('bonfire_morph_button_animation', $_POST['morph_button_animation']); }
		/* menu button animation speed */
		update_option('bonfire_morph_menu_button_speed', $_POST['morph_menu_button_speed']);
		
		/* absolute/fixed positioning */
		if ( isset ($_POST['morph_absolute_position'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_morph_absolute_position', $display);
		/* hide main menu button */
		if ( isset ($_POST['morph_hide_main_menu_button'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_morph_hide_main_menu_button', $display);
		/* hide search */
		if ( isset ($_POST['morph_hide_search'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_morph_hide_search', $display);
		/* hide secondary menu */
		if ( isset ($_POST['morph_hide_secondary_menu'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_morph_hide_secondary_menu', $display);
		/* background overlay opacity */
		update_option('bonfire_morph_background_overlay_opacity', $_POST['morph_background_overlay_opacity']);
		/* don't load FontAwesome */
		if ( isset ($_POST['morph_fa_no_load'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_morph_fa_no_load', $display);
		
		/* heading text */
		update_option('bonfire_morph_heading_text', $_POST['morph_heading_text']);
		/* subheading text */
		update_option('bonfire_morph_subheading_text', $_POST['morph_subheading_text']);
		/* custom heading height */
		update_option('bonfire_morph_heading_height', $_POST['morph_heading_height']);
		/* heading overlay opacity */
		update_option('bonfire_morph_heading_overlay', $_POST['morph_heading_overlay']);
		/* heading image */
		update_option('bonfire_morph_heading_image', $_POST['morph_heading_image']);
		/* heading pattern */
		if ( isset ($_POST['morph_heading_image_pattern'])=='on') { $display = 'checked'; } else { $display = ''; }
	    update_option('bonfire_morph_heading_image_pattern', $display);
		
		/* larger than, lower than */
		update_option('bonfire_morph_larger_than', $_POST['morph_larger_than']);
		update_option('bonfire_morph_smaller_than', $_POST['morph_smaller_than']);

	}
	add_action('admin_menu', 'bonfire_morph_admin_menu');
	?>
<?php

	//
	// Add meta tag to theme header (no tap highlighting on Windows devices)
	//
	
	function bonfire_morph_meta() {
	?>
		<meta name="msapplication-tap-highlight" content="no" /> 
	<?php
	}
	add_action('wp_head','bonfire_morph_meta');

	//
	// Add menu to theme
	//
	
	function bonfire_morph_footer() {
	?>
		
		<!-- BEGIN MAIN MENU BUTTON -->
		<?php if( get_option('bonfire_morph_hide_main_menu_button') ) { ?>
		<?php } else { ?>
		<div class="morph-main-menu-button-wrapper<?php if ( is_admin_bar_showing() ) { ?> wp-toolbar-active<?php } ?><?php if( get_option('bonfire_morph_absolute_position') ) { ?> morph-absolute<?php } ?>">
			<?php if(get_option('bonfire_morph_menu_button_style') == "morphfourlines") { ?>
				<div class="morph-menu-button-four">
					<div class="morph-menu-button-four-middle"></div>
				</div>
			<?php } else if(get_option('bonfire_morph_menu_button_style') == "morphthreelinesalt") { ?>
				<div class="morph-menu-button-three-alt">
					<div class="morph-menu-button-three-alt-middle"></div>
				</div>
			<?php } else { ?>
				<div class="morph-main-menu-button">
					<div class="morph-main-menu-button-middle"></div>
				</div>
			<?php } ?>
		</div>
		<?php } ?>
		<!-- END MAIN MENU BUTTON -->

		<!-- BEGIN MAIN WRAPPER -->
		<div class="morph-main-wrapper<?php if ( is_admin_bar_showing() ) { ?> wp-toolbar-active<?php } ?>">
			<div class="morph-main-wrapper-inner">
				<div class="morph-main">
	
					<!-- BEGIN HEADING CONTENT -->
					<div class="morph-heading-wrapper">
						<div class="morph-heading-inner">
							<!-- BEGIN HEADING TEXT -->
							<div class="morph-heading-text">
								<?php echo stripslashes(get_option('bonfire_morph_heading_text')); ?>
							</div>
							<!-- END HEADING TEXT -->
							<!-- BEGIN SUBHEADING TEXT -->
							<?php if( get_option('bonfire_morph_subheading_text') ) { ?>
							<div class="morph-subheading-text">
								<?php echo stripslashes(get_option('bonfire_morph_subheading_text')); ?>
							</div>
							<?php } ?>
							<!-- END SUBHEADING TEXT -->
							
							<!-- BEGIN SEARCH BUTTON -->
							<?php if( get_option('bonfire_morph_hide_search') ) { ?>
							<?php } else { ?>
							<div class="morph-search-button">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
								<path id="magnifier-3-icon" d="M208.464,363.98c-86.564,0-156.989-70.426-156.989-156.99C51.475,120.426,121.899,50,208.464,50
									c86.565,0,156.991,70.426,156.991,156.991C365.455,293.555,295.029,363.98,208.464,363.98z M208.464,103.601
									c-57.01,0-103.389,46.381-103.389,103.39s46.379,103.389,103.389,103.389c57.009,0,103.391-46.38,103.391-103.389
									S265.473,103.601,208.464,103.601z M367.482,317.227c-14.031,20.178-31.797,37.567-52.291,51.166L408.798,462l51.728-51.729
									L367.482,317.227z"/>
								</svg>
							</div>
							<?php } ?>
							<!-- END SEARCH BUTTON -->
					
							<!-- BEGIN SEARCH FORM CLOSE ICON -->
							<div class="morph-search-close-wrapper">
									<div class="morph-search-close-button">
									</div>
							</div>
							<!-- END SEARCH FORM CLOSE ICON -->

							<!-- BEGIN SEARCH FORM -->
							<div class="morph-search-wrapper">
								<form method="get" id="searchform" action="<?php echo esc_url( home_url('') ); ?>/">
									<input type="text" name="s" id="s">
								</form>
							</div>
							<!-- END SEARCH FORM -->
							
							<!-- BEGIN SECONDARY MENU BUTTON -->
							<?php if( get_option('bonfire_morph_hide_secondary_menu') ) { ?>
							<?php } else { ?>
							<div class="morph-secondary-menu-button">
								<!-- BEGIN SECONDARY MENU -->
								<div class="morph-secondary-menu-wrapper">
									<?php wp_nav_menu( array( 'container_class' => 'morph-by-bonfire-secondary', 'theme_location' => 'morph-by-bonfire-secondary', 'fallback_cb' => '' ) ); ?>
								</div>
								<!-- END SECONDARY MENU -->
								
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
								<path id="menu-7-icon" d="M153.415,256c0,28.558-23.15,51.708-51.707,51.708C73.15,307.708,50,284.558,50,256
									s23.15-51.708,51.708-51.708C130.265,204.292,153.415,227.442,153.415,256z M256,204.292c-28.558,0-51.708,23.15-51.708,51.708
									s23.15,51.708,51.708,51.708s51.708-23.15,51.708-51.708S284.558,204.292,256,204.292z M410.292,204.292
									c-28.557,0-51.707,23.15-51.707,51.708s23.15,51.708,51.707,51.708C438.85,307.708,462,284.558,462,256
									S438.85,204.292,410.292,204.292z"/>
								</svg>
							</div>
							<?php } ?>
							<!-- END SECONDARY MENU BUTTON -->
						</div>
					</div>
					<!-- END HEADING CONTENT -->
					
					<!-- BEGIN HEADING BACKGROUND OVERLAY -->
					<div class="morph-heading-overlay"></div>
					<!-- END HEADING BACKGROUND OVERLAY -->
					
					<!-- BEGIN HEADING IMAGE -->
					<div class="morph-heading-image"></div>
					<!-- END HEADING IMAGE -->
	
					<!-- BEGIN MAIN MENU + WIDGETS -->
					<div class="morph-menu-wrapper">
						<!-- BEGIN MAIN MENU -->
						<?php wp_nav_menu( array( 'container_class' => 'morph-by-bonfire', 'theme_location' => 'morph-by-bonfire', 'fallback_cb' => '' ) ); ?>
						<!-- END MAIN MENU -->
						
						<!-- BEGIN WIDGETS -->
						<div class="morph-widgets-wrapper">
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Morph Widgets') ) : ?><?php endif; ?>
						</div>
						<!-- END WIDGETS -->
					</div>
					<!-- END MAIN MENU + WIDGETS -->
	
				</div>
			</div>
		</div>
		<!-- END MAIN WRAPPER -->
		
		<!-- BEGIN MAIN BACKGROUND -->
		<div class="morph-main-background<?php if ( is_admin_bar_showing() ) { ?> wp-toolbar-active<?php } ?>">
		</div>
		<!-- END MAIN BACKGROUND -->
		
		<!-- BEGIN BACKGROUND OVERLAY (when menu open) -->
		<div class="morph-background-overlay"></div>
		<!-- END BACKGROUND OVERLAY (when menu open) -->

	<?php
	}
	add_action('wp_footer','bonfire_morph_footer');

	//
	// ENQUEUE morph.css
	//
	function bonfire_morph_css() {
		wp_register_style( 'bonfire-morph-css', plugins_url( '/morph.css', __FILE__ ) . '', array(), '1', 'all' );
		wp_enqueue_style( 'bonfire-morph-css' );
	}
	add_action( 'wp_enqueue_scripts', 'bonfire_morph_css' );

	//
	// ENQUEUE morph-accordion.js (only if main menu not disabled)
	//
	function bonfire_morph_accordion() {
		wp_register_script( 'bonfire-morph-accordion', plugins_url( '/morph-accordion.js', __FILE__ ) . '', array( 'jquery' ), '1' );  
		wp_enqueue_script( 'bonfire-morph-accordion' );
	}
	add_action( 'wp_enqueue_scripts', 'bonfire_morph_accordion' );

	//
	// ENQUEUE morph.js
	//
	function bonfire_morph_js() {
		wp_register_script( 'bonfire-morph-js', plugins_url( '/morph.js', __FILE__ ) . '', array( 'jquery' ), '1', true );  
		wp_enqueue_script( 'bonfire-morph-js' );
	}
	add_action( 'wp_enqueue_scripts', 'bonfire_morph_js' );
	
	//
	// ENQUEUE search.js
	//
	function bonfire_morph_search_js() {
		wp_register_script( 'bonfire-morph-search-js', plugins_url( '/search.js', __FILE__ ) . '', array( 'jquery' ), '1', true );
		wp_enqueue_script( 'bonfire-morph-search-js' );
	}
	add_action( 'wp_enqueue_scripts', 'bonfire_morph_search_js' );

	//
	// Enqueue Google WebFonts
	//
	function bonfire_morph_font() {
	$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'bonfire-morph-font', "$protocol://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css" );
	}
	add_action( 'wp_enqueue_scripts', 'bonfire_morph_font' );
	
	//
	// Enqueue font-awesome.min.css (icons for menu, if option to hide not enabled)
	//
	if( get_option('bonfire_morph_fa_no_load') ) {
	} else {
		function bonfire_morph_fontawesome() {  
			wp_register_style( 'morph-fontawesome', plugins_url( '/fonts/font-awesome/css/font-awesome.min.css', __FILE__ ) . '', array(), '1', 'all' );  
			wp_enqueue_style( 'morph-fontawesome' );
		}
		add_action( 'wp_enqueue_scripts', 'bonfire_morph_fontawesome' );
	}

	//
	// Register Custom Menu Function
	//
	if (function_exists('register_nav_menus')) {
		register_nav_menus( array(
			'morph-by-bonfire' => ( 'Morph plugin (primary)' ),
			'morph-by-bonfire-secondary' => ( 'Morph plugin (secondary)' )
		) );
	}

	///////////////////////////////////////
	// Register Widgets
	///////////////////////////////////////
	function bonfire_morph_widgets_init() {
	
		register_sidebar( array(
		'name' => __( 'Morph Widgets', 'bonfire' ),
		'id' => 'morph-main-widgets',
		'description' => __( 'Drag widgets here', 'bonfire' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
		));

	}
	add_action( 'widgets_init', 'bonfire_morph_widgets_init' );

	//
	// Add color options to Appearance > Customize
	//
	add_action( 'customize_register', 'bonfire_morph_customize_register' );
	function bonfire_morph_customize_register($wp_customize)
	{
		$colors = array();
		/* menu button */
		$colors[] = array( 'slug'=>'bonfire_morph_menu_button_color', 'default' => '', 'label' => __( 'Menu button', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_menu_button_hover_color', 'default' => '', 'label' => __( 'Menu button hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_menu_button_active_color', 'default' => '', 'label' => __( 'Menu button active', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_menu_button_active_hover_color', 'default' => '', 'label' => __( 'Menu button active hover', 'bonfire' ) );
		/* secondary menu button */
		$colors[] = array( 'slug'=>'bonfire_morph_secondary_menu_button_color', 'default' => '', 'label' => __( 'Secondary menu button', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_secondary_menu_button_hover_color', 'default' => '', 'label' => __( 'Secondary menu button hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_secondary_menu_button_active_color', 'default' => '', 'label' => __( 'Secondary menu button active', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_secondary_menu_button_active_hover_color', 'default' => '', 'label' => __( 'Secondary menu button active hover', 'bonfire' ) );
		/* search button */
		$colors[] = array( 'slug'=>'bonfire_morph_search_button_color', 'default' => '', 'label' => __( 'Search button', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_search_button_hover_color', 'default' => '', 'label' => __( 'Search button hover', 'bonfire' ) );
		/* search close button */
		$colors[] = array( 'slug'=>'bonfire_morph_search_close_button_color', 'default' => '', 'label' => __( 'Search close button', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_search_close_button_hover_color', 'default' => '', 'label' => __( 'Search close button hover', 'bonfire' ) );
		/* search field border + text */
		$colors[] = array( 'slug'=>'bonfire_morph_search_border_color', 'default' => '', 'label' => __( 'Search field border', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_search_text_color', 'default' => '', 'label' => __( 'Search field text', 'bonfire' ) );
		/* heading + sub-heading text */
		$colors[] = array( 'slug'=>'bonfire_morph_heading_text_color', 'default' => '', 'label' => __( 'Heading text', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_subheading_text_color', 'default' => '', 'label' => __( 'Sub-heading text', 'bonfire' ) );
		/* heading overlay */
		$colors[] = array( 'slug'=>'bonfire_morph_heading_overlay_color', 'default' => '', 'label' => __( 'Heading overlay', 'bonfire' ) );
		/* background overlay */
		$colors[] = array( 'slug'=>'bonfire_morph_background_overlay_color', 'default' => '', 'label' => __( 'Background overlay', 'bonfire' ) );
		/* main menu */
		$colors[] = array( 'slug'=>'bonfire_morph_main_menu_background_color', 'default' => '', 'label' => __( 'Main menu background', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_main_menu_item_color', 'default' => '', 'label' => __( 'Main menu item', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_main_menu_item_hover_color', 'default' => '', 'label' => __( 'Main menu item hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_main_menu_subitem_color', 'default' => '', 'label' => __( 'Main menu sub item', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_main_menu_subitem_hover_color', 'default' => '', 'label' => __( 'Main menu sub item hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_main_menu_arrow_color', 'default' => '', 'label' => __( 'Main menu sub-menu arrow', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_main_menu_arrow_hover_color', 'default' => '', 'label' => __( 'Main menu sub-menu arrow hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_main_menu_icon_color', 'default' => '', 'label' => __( 'Main menu icon', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_main_menu_icon_hover_color', 'default' => '', 'label' => __( 'Main menu icon hover', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_main_menu_border_color', 'default' => '', 'label' => __( 'Main menu border color', 'bonfire' ) );
		/* secondary menu */
		$colors[] = array( 'slug'=>'bonfire_morph_secondary_menu_background_color', 'default' => '', 'label' => __( 'Secondary menu background', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_secondary_menu_border_color', 'default' => '', 'label' => __( 'Secondary menu border (left, top, right)', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_secondary_menu_bottom_border_color', 'default' => '', 'label' => __( 'Secondary menu border (bottom)', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_secondary_menu_item_color', 'default' => '', 'label' => __( 'Secondary menu item', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_secondary_menu_item_hover_color', 'default' => '', 'label' => __( 'Secondary menu item hover', 'bonfire' ) );
		/* widgets */
		$colors[] = array( 'slug'=>'bonfire_morph_widget_title_color', 'default' => '', 'label' => __( 'Widget title', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_widget_text_color', 'default' => '', 'label' => __( 'Widget text', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_widget_secondary_text_color', 'default' => '', 'label' => __( 'Widget text secondary (dates, captions)', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_widget_link_color', 'default' => '', 'label' => __( 'Widget link', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_widget_search_border_color', 'default' => '', 'label' => __( 'Widget search field border', 'bonfire' ) );
		$colors[] = array( 'slug'=>'bonfire_morph_widget_search_field_color', 'default' => '', 'label' => __( 'Search field text', 'bonfire' ) );

	foreach($colors as $color)
	{

	/* create custom color customization section */
	$wp_customize->add_section( 'morph_plugin_colors' , array( 'title' => __('Morph Plugin Colors', 'bonfire'), 'priority' => 30 ));
	$wp_customize->add_setting( $color['slug'], array( 'default' => $color['default'], 'type' => 'option', 'capability' => 'edit_theme_options' ));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array( 'label' => $color['label'], 'section' => 'morph_plugin_colors', 'settings' => $color['slug'] )));
	}
	}

	//
	// Insert theme customizer options into the footer
	//
	function bonfire_morph_header_customize() {
	?>

		<!-- BEGIN CUSTOM COLORS (WP THEME CUSTOMIZER) -->
		<!-- menu button -->
		<?php $bonfire_morph_menu_button_color = get_option('bonfire_morph_menu_button_color'); ?>
		<?php $bonfire_morph_menu_button_hover_color = get_option('bonfire_morph_menu_button_hover_color'); ?>
		<?php $bonfire_morph_menu_button_active_color = get_option('bonfire_morph_menu_button_active_color'); ?>
		<?php $bonfire_morph_menu_button_active_hover_color = get_option('bonfire_morph_menu_button_active_hover_color'); ?>
		<!-- secondary menu button -->
		<?php $bonfire_morph_secondary_menu_button_color = get_option('bonfire_morph_secondary_menu_button_color'); ?>
		<?php $bonfire_morph_secondary_menu_button_hover_color = get_option('bonfire_morph_secondary_menu_button_hover_color'); ?>
		<?php $bonfire_morph_secondary_menu_button_active_color = get_option('bonfire_morph_secondary_menu_button_active_color'); ?>
		<?php $bonfire_morph_secondary_menu_button_active_hover_color = get_option('bonfire_morph_secondary_menu_button_active_hover_color'); ?>
		<!-- search button -->
		<?php $bonfire_morph_search_button_color = get_option('bonfire_morph_search_button_color'); ?>
		<?php $bonfire_morph_search_button_hover_color = get_option('bonfire_morph_search_button_hover_color'); ?>
		<!-- search close button -->
		<?php $bonfire_morph_search_close_button_color = get_option('bonfire_morph_search_close_button_color'); ?>
		<?php $bonfire_morph_search_close_button_hover_color = get_option('bonfire_morph_search_close_button_hover_color'); ?>
		<!-- search field border + text -->
		<?php $bonfire_morph_search_border_color = get_option('bonfire_morph_search_border_color'); ?>
		<?php $bonfire_morph_search_text_color = get_option('bonfire_morph_search_text_color'); ?>
		<!-- heading + sub-heading text -->
		<?php $bonfire_morph_heading_text_color = get_option('bonfire_morph_heading_text_color'); ?>
		<?php $bonfire_morph_subheading_text_color = get_option('bonfire_morph_subheading_text_color'); ?>
		<!-- heading overlay -->
		<?php $bonfire_morph_heading_overlay_color = get_option('bonfire_morph_heading_overlay_color'); ?>
		<!-- background overlay -->
		<?php $bonfire_morph_background_overlay_color = get_option('bonfire_morph_background_overlay_color'); ?>
		<!-- main menu -->
		<?php $bonfire_morph_main_menu_background_color = get_option('bonfire_morph_main_menu_background_color'); ?>
		<?php $bonfire_morph_main_menu_item_color = get_option('bonfire_morph_main_menu_item_color'); ?>
		<?php $bonfire_morph_main_menu_item_hover_color = get_option('bonfire_morph_main_menu_item_hover_color'); ?>
		<?php $bonfire_morph_main_menu_subitem_color = get_option('bonfire_morph_main_menu_subitem_color'); ?>
		<?php $bonfire_morph_main_menu_subitem_hover_color = get_option('bonfire_morph_main_menu_subitem_hover_color'); ?>
		<?php $bonfire_morph_main_menu_arrow_color = get_option('bonfire_morph_main_menu_arrow_color'); ?>
		<?php $bonfire_morph_main_menu_arrow_hover_color = get_option('bonfire_morph_main_menu_arrow_hover_color'); ?>
		<?php $bonfire_morph_main_menu_icon_color = get_option('bonfire_morph_main_menu_icon_color'); ?>
		<?php $bonfire_morph_main_menu_icon_hover_color = get_option('bonfire_morph_main_menu_icon_hover_color'); ?>
		<?php $bonfire_morph_main_menu_border_color = get_option('bonfire_morph_main_menu_border_color'); ?>
		<!-- secondary menu -->
		<?php $bonfire_morph_secondary_menu_background_color = get_option('bonfire_morph_secondary_menu_background_color'); ?>
		<?php $bonfire_morph_secondary_menu_border_color = get_option('bonfire_morph_secondary_menu_border_color'); ?>
		<?php $bonfire_morph_secondary_menu_bottom_border_color = get_option('bonfire_morph_secondary_menu_bottom_border_color'); ?>
		<?php $bonfire_morph_secondary_menu_item_color = get_option('bonfire_morph_secondary_menu_item_color'); ?>
		<?php $bonfire_morph_secondary_menu_item_hover_color = get_option('bonfire_morph_secondary_menu_item_hover_color'); ?>
		<!-- widgets -->
		<?php $bonfire_morph_widget_title_color = get_option('bonfire_morph_widget_title_color'); ?>
		<?php $bonfire_morph_widget_text_color = get_option('bonfire_morph_widget_text_color'); ?>
		<?php $bonfire_morph_widget_secondary_text_color = get_option('bonfire_morph_widget_secondary_text_color'); ?>
		<?php $bonfire_morph_widget_link_color = get_option('bonfire_morph_widget_link_color'); ?>
		<?php $bonfire_morph_widget_search_border_color = get_option('bonfire_morph_widget_search_border_color'); ?>
		<?php $bonfire_morph_widget_search_field_color = get_option('bonfire_morph_widget_search_field_color'); ?>

		<style>
		/**************************************************************
		*** CUSTOM COLORS
		**************************************************************/
		/* widgets */
		.morph-widgets-wrapper .widgettitle { color:<?php echo $bonfire_morph_widget_title_color; ?>; }
		.morph-widgets-wrapper .widget { color:<?php echo $bonfire_morph_widget_text_color; ?>; }
		.morph-widgets-wrapper .post-date,
		.morph-widgets-wrapper .rss-date,
		.morph-widgets-wrapper .wp-caption,
		.morph-widgets-wrapper .wp-caption-text { color:<?php echo $bonfire_morph_widget_secondary_text_color; ?>; }
		.morph-widgets-wrapper .widget a { color:<?php echo $bonfire_morph_widget_link_color; ?>; }
		.morph-widgets-wrapper .widget_search input { color:<?php echo $bonfire_morph_widget_search_field_color; ?>; border-color:<?php echo $bonfire_morph_widget_search_border_color; ?>; }
		
		/* different distance for different menu buttons */
		<?php if(get_option('bonfire_morph_menu_button_style') == "morphfourlines") { ?>
		.morph-main-menu-button-wrapper { top:13px; left:16px; }
		<?php } else if(get_option('bonfire_morph_menu_button_style') == "morphthreelinesalt") { ?>
		.morph-main-menu-button-wrapper { top:16px; left:15px; }
		<?php } ?>
		/* menu button */
		.morph-main-menu-button:after,
		.morph-main-menu-button:before,
		.morph-main-menu-button div.morph-main-menu-button-middle:before,
		.morph-menu-button-three-alt:after,
		.morph-menu-button-three-alt:before,
		.morph-menu-button-three-alt div.morph-menu-button-three-alt-middle:before,
		.morph-menu-button-four:after,
		.morph-menu-button-four:before,
		.morph-menu-button-four div.morph-menu-button-four-middle:before,
		.morph-menu-button-four div.morph-menu-button-four-middle:after { background-color:<?php echo $bonfire_morph_menu_button_color; ?>; }
		/* main menu button hover */
		<?php if ( wp_is_mobile() ) { ?>
		<?php } else { ?>
		.morph-main-menu-button:hover:after,
		.morph-main-menu-button:hover:before,
		.morph-main-menu-button:hover div.morph-main-menu-button-middle:before,
		.morph-menu-button-three-alt:hover:after,
		.morph-menu-button-three-alt:hover:before,
		.morph-menu-button-three-alt:hover div.morph-menu-button-three-alt-middle:before,
		.morph-menu-button-four:hover:after,
		.morph-menu-button-four:hover:before,
		.morph-menu-button-four:hover div.morph-menu-button-four-middle:before,
		.morph-menu-button-four:hover div.morph-menu-button-four-middle:after { background-color:<?php echo $bonfire_morph_menu_button_hover_color; ?>; }
		<?php } ?>
		/* menu button active */
		.morph-menu-active .morph-main-menu-button:after,
		.morph-menu-active .morph-main-menu-button:before,
		.morph-menu-active .morph-main-menu-button div.morph-main-menu-button-middle:before,
		.morph-menu-active .morph-menu-button-three-alt:after,
		.morph-menu-active .morph-menu-button-three-alt:before,
		.morph-menu-active .morph-menu-button-three-alt div.morph-menu-button-three-alt-middle:before,
		.morph-menu-active .morph-menu-button-four:after,
		.morph-menu-active .morph-menu-button-four:before,
		.morph-menu-active .morph-menu-button-four div.morph-menu-button-four-middle:before,
		.morph-menu-active .morph-menu-button-four div.morph-menu-button-four-middle:after { background-color:<?php echo $bonfire_morph_menu_button_active_color; ?>; }
		/* menu button active hover */
		<?php if ( wp_is_mobile() ) { ?>
		<?php } else { ?>
		.morph-menu-active .morph-main-menu-button:hover:after,
		.morph-menu-active .morph-main-menu-button:hover:before,
		.morph-menu-active .morph-main-menu-button:hover div.morph-main-menu-button-middle:before,
		.morph-menu-active .morph-menu-button-three-alt:hover:after,
		.morph-menu-active .morph-menu-button-three-alt:hover:before,
		.morph-menu-active .morph-menu-button-three-alt:hover div.morph-menu-button-three-alt-middle:before,
		.morph-menu-active .morph-menu-button-four:hover:after,
		.morph-menu-active .morph-menu-button-four:hover:before,
		.morph-menu-active .morph-menu-button-four:hover div.morph-menu-button-four-middle:before,
		.morph-menu-active .morph-menu-button-four:hover div.morph-menu-button-four-middle:after { background-color:<?php echo $bonfire_morph_menu_button_active_hover_color; ?>; }
		<?php } ?>
		/* custom menu button speed */
		.morph-main-menu-button:after,
		.morph-main-menu-button:before,
		.morph-main-menu-button div.morph-main-menu-button-middle:before,
		.morph-menu-button-three-alt:after,
		.morph-menu-button-three-alt:before,
		.morph-menu-button-three-alt div.morph-menu-button-three-alt-middle:before,
		.morph-menu-button-four:after,
		.morph-menu-button-four:before,
		.morph-menu-button-four div.morph-menu-button-four-middle:before,
		.morph-menu-button-four div.morph-menu-button-four-middle:after {
			-webkit-transition:all <?php echo get_option('bonfire_morph_menu_button_speed'); ?>s ease !important;
			-moz-transition:all <?php echo get_option('bonfire_morph_menu_button_speed'); ?>s ease !important;
			transition:all <?php echo get_option('bonfire_morph_menu_button_speed'); ?>s ease !important;
		}

		/* secondary menu button */
		.morph-secondary-menu-button svg { fill:<?php echo $bonfire_morph_secondary_menu_button_color; ?>;}
		/* secondary menu button hover */
		<?php if ( wp_is_mobile() ) { ?>
		<?php } else { ?>
		.morph-secondary-menu-button svg:hover { fill:#A0A0A0; fill:<?php echo $bonfire_morph_secondary_menu_button_hover_color; ?>;}
		<?php } ?>
		/* secondary menu button active */
		.morph-secondary-menu-button-active svg { fill:<?php echo $bonfire_morph_secondary_menu_button_active_color; ?>; }
		/* secondary menu button active hover */
		<?php if ( wp_is_mobile() ) { ?>
		<?php } else { ?>
		.morph-secondary-menu-button-active svg:hover { fill:<?php echo $bonfire_morph_secondary_menu_button_active_hover_color; ?>; }
		<?php } ?>
		
		/* search button */
		.morph-search-button svg { fill:<?php echo get_option('bonfire_morph_search_button_color'); ?>; }
		.morph-search-button:hover svg { fill:<?php echo get_option('bonfire_morph_search_button_hover_color'); ?>; }
		/* search close button */
		.morph-search-close-button:before,
		.morph-search-close-button:after { background-color:<?php echo get_option('bonfire_morph_search_close_button_color'); ?>; }
		.morph-search-close-wrapper:hover .morph-search-close-button:before,
		.morph-search-close-wrapper:hover .morph-search-close-button:after { background-color:<?php echo get_option('bonfire_morph_search_close_button_hover_color'); ?>; }
		/* search field border + text */
		.morph-search-wrapper { border-color:<?php echo get_option('bonfire_morph_search_border_color'); ?>; }
		.morph-search-wrapper #searchform input { color:<?php echo get_option('bonfire_morph_search_text_color'); ?>; }
		
		/* heading + sub-heading text */
		.morph-heading-text { color:<?php echo get_option('bonfire_morph_heading_text_color'); ?>; }
		.morph-subheading-text { color:<?php echo get_option('bonfire_morph_subheading_text_color'); ?>; }
		
		/* heading overlay */
		.morph-heading-overlay { background-color:<?php echo get_option('bonfire_morph_heading_overlay_color'); ?>; }
		/* background overlay */
		.morph-background-overlay { background-color:<?php echo get_option('bonfire_morph_background_overlay_color'); ?>; }

		/* main menu */
		.morph-main-background { background-color:<?php echo get_option('bonfire_morph_main_menu_background_color'); ?>; }
		.morph-by-bonfire ul li a { color:<?php echo get_option('bonfire_morph_main_menu_item_color'); ?>; }
		.morph-by-bonfire ul li a:hover {color:<?php echo get_option('bonfire_morph_main_menu_item_hover_color'); ?>; }
		.morph-by-bonfire ul.sub-menu li a { color:<?php echo get_option('bonfire_morph_main_menu_subitem_color'); ?>; }
		.morph-by-bonfire ul.sub-menu li a:hover { color:<?php echo get_option('bonfire_morph_main_menu_subitem_hover_color'); ?>; }
		.morph-by-bonfire .menu li span svg { fill:<?php echo get_option('bonfire_morph_main_menu_arrow_color'); ?>; }
		<?php if ( wp_is_mobile() ) { ?>
		<?php } else { ?>
		.morph-by-bonfire .menu li span:hover svg { fill:#736F6C; fill:<?php echo get_option('bonfire_morph_main_menu_arrow_hover_color'); ?>; }
		<?php } ?>
		.morph-by-bonfire a i { color:<?php echo get_option('bonfire_morph_main_menu_icon_color'); ?>; }
		.morph-by-bonfire a:hover i { color:<?php echo get_option('bonfire_morph_main_menu_icon_hover_color'); ?>; }
		.morph-by-bonfire ul li.border a { border-color:<?php echo get_option('bonfire_morph_main_menu_border_color'); ?>; }
		
		/* secondary menu */
		.morph-secondary-menu-wrapper { background-color:<?php echo get_option('bonfire_morph_secondary_menu_background_color'); ?>; border-color:<?php echo get_option('bonfire_morph_secondary_menu_border_color'); ?>; }
		.morph-secondary-menu-wrapper:after { background-color:<?php echo get_option('bonfire_morph_secondary_menu_bottom_border_color'); ?>; }
		.morph-secondary-menu-wrapper a { color:<?php echo get_option('bonfire_morph_secondary_menu_item_color'); ?>; }
		.morph-secondary-menu-wrapper a:hover { color:<?php echo get_option('bonfire_morph_secondary_menu_item_hover_color'); ?>; }
		
		/* background overlay opacity */
		.morph-background-overlay-active { opacity:<?php echo get_option('bonfire_morph_background_overlay_opacity'); ?>; }

		/* menu button animations (-/X) */
		<?php if(get_option('bonfire_morph_button_animation') == "morphminusanimation") { ?>
			/* middle bar #1 animation (3 lines) */
			.morph-menu-active .morph-main-menu-button div.morph-main-menu-button-middle:before {
				margin:0 0 -1px 0;
			}
			/* top bar fade out (3 lines) */
			.morph-menu-active .morph-main-menu-button:before {
				opacity:0;
				
				-webkit-transform:translateY(4px);
				-moz-transform:translateY(4px);
				-ms-transform:translateY(4px);
				transform:translateY(4px);
			}
			/* bottom bar fade out (3 lines) */
			.morph-menu-active .morph-main-menu-button:after {
				opacity:0;
				
				-webkit-transform:translateY(-3px);
				-moz-transform:translateY(-3px);
				-ms-transform:translateY(-3px);
				transform:translateY(-3px);
			}
			/* middle bar animation (alternate 3 lines) */
			.morph-menu-active .morph-menu-button-three-alt div.morph-menu-button-three-alt-middle:before {
				margin:0 0 -1px 0;
			}
			/* top bar fade out (alternate 3 lines) */
			.morph-menu-active .morph-menu-button-three-alt:before {
				width:0;
				
				-webkit-transition:all .25s ease;
				-moz-transition:all .25s ease;
				transition:all .25s ease;
			}
			/* bottom bar fade out (alternate 3 lines) */
			.morph-menu-active .morph-menu-button-three-alt:after {
				width:0;
				
				-webkit-transition:all .25s ease;
				-moz-transition:all .25s ease;
				transition:all .25s ease;
			}
			/* top bar animation (alternate 4 lines) */
			.morph-menu-active .morph-menu-button-four:before {
				-webkit-transform:translateY(9px);
				-moz-transform:translateY(9px);
				transform:translateY(9px);
			}
			/* middle bar #1 animation (alternate 4 lines) */
			.morph-menu-active .morph-menu-button-four div.morph-menu-button-four-middle:before {
				-webkit-transform:translateY(3px);
				-moz-transform:translateY(3px);
				transform:translateY(3px);
			}
			/* middle bar #2 animation (alternate 4 lines) */
			.morph-menu-active .morph-menu-button-four div.morph-menu-button-four-middle:after {
				-webkit-transform:translateY(-3px);
				-moz-transform:translateY(-3px);
				transform:translateY(-3px);
			}
			/* bottom bar animation (alternate 4 lines) */
			.morph-menu-active .morph-menu-button-four:after {
				-webkit-transform:translateY(-9px);
				-moz-transform:translateY(-9px);
				transform:translateY(-9px);
			}
		<?php } else if(get_option('bonfire_morph_button_animation') == "morphxanimation") { ?>
			/* top bar animation (3 lines) */
			.morph-menu-active .morph-main-menu-button:before {
				margin:2px 0 0 0;
				
				transform:translateY(4px) rotate(45deg);
				-moz-transform:translateY(4px) rotate(45deg);
				-ms-transform:translateY(4px) rotate(45deg);
				-webkit-transform:translateY(4px) rotate(45deg);
			}
			/* bottom bar animation (3 lines) */
			.morph-menu-active .morph-main-menu-button:after {
				margin:-1px 0 0 0;
				
				transform:translateY(-3px) rotate(-45deg);
				-moz-transform:translateY(-3px) rotate(-45deg);
				-ms-transform:translateY(-3px) rotate(-45deg);
				-webkit-transform:translateY(-3px) rotate(-45deg);
			}
			/* middle bar fade out (3 lines) */
			.morph-menu-active div.morph-main-menu-button-middle:before {
				opacity:0;
				
				-webkit-transition:all .15s ease;
				-moz-transition:all .15s ease;
				-ms-transition:all .15s ease;
				transition:all .15s ease;
			}
			/* top bar animation (alternate 3 lines) */
			.morph-menu-active .morph-menu-button-three-alt:before {
				width:24px;
				margin-right:7px;
				
				transform:translateY(6px) rotate(45deg);
				-moz-transform:translateY(6px) rotate(45deg);
				-webkit-transform:translateY(6px) rotate(45deg);
			}
			/* bottom bar animation (alternate 3 lines) */
			.morph-menu-active .morph-menu-button-three-alt:after {
				width:24px;
				margin:8px 0 0 0px;
				
				transform:translateY(-10px) rotate(-45deg);
				-moz-transform:translateY(-10px) rotate(-45deg);
				-webkit-transform:translateY(-10px) rotate(-45deg);
			}
			/* middle bar fade out (alternate 3 lines) */
			.morph-menu-active div.morph-menu-button-three-alt-middle:before {
				opacity:0;
				
				-webkit-transition:all .15s ease;
				-moz-transition:all .15s ease;
				transition:all .15s ease;
			}
			/* top bar animation (alternate 4 lines) */
			.morph-menu-active .morph-menu-button-four:before {
				width:11px;
				
				transform:translateY(3px) translateX(-1px) rotate(45deg);
				-moz-transform:translateY(3px) translateX(-1px) rotate(45deg);
				-webkit-transform:translateY(3px) translateX(-1px) rotate(45deg);
			}
			/* middle bar #1 animation (alternate 4 lines) */
			.morph-menu-active .morph-menu-button-four div.morph-menu-button-four-middle:before {
				width:11px;
				
				transform:translateY(-3px) translateX(11px) rotate(-45deg);
				-moz-transform:translateY(-3px) translateX(11px) rotate(-45deg);
				-webkit-transform:translateY(-3px) translateX(11px) rotate(-45deg);
			}
			/* middle bar #2 animation (alternate 4 lines) */
			.morph-menu-active .morph-menu-button-four div.morph-menu-button-four-middle:after {
				width:11px;
				
				transform:translateY(3px) translateX(-1px) rotate(-45deg);
				-moz-transform:translateY(3px) translateX(-1px) rotate(-45deg);
				-webkit-transform:translateY(3px) translateX(-1px) rotate(-45deg);
			}
			/* bottom bar animation (alternate 4 lines) */
			.morph-menu-active .morph-menu-button-four:after {
				width:11px;
				
				transform:translateY(-3px) translateX(11px) rotate(45deg);
				-moz-transform:translateY(-3px) translateX(11px) rotate(45deg);
				-webkit-transform:translateY(-3px) translateX(11px) rotate(45deg);
			}
		<?php } else { ?>
		<?php } ?>

		/* custom heading height */
		.morph-heading-wrapper,
		.morph-heading-overlay,
		.morph-heading-image { height:<?php echo get_option('bonfire_morph_heading_height'); ?>px; }
		.morph-menu-wrapper { top:<?php echo get_option('bonfire_morph_heading_height'); ?>px; }
		/* heading overlay opacity */
		.morph-heading-overlay { opacity:<?php echo get_option('bonfire_morph_heading_overlay'); ?>; }
		/* heading image */
		.morph-heading-image {
			background-image:url(<?php echo get_option('bonfire_morph_heading_image'); ?>);
		}
		/* heading image pattern */
		<?php if(get_option('bonfire_morph_heading_image_pattern')) { ?>
		.morph-heading-image {
			background-size:auto;
		}
		<?php } ?>
		
		/* hide morph between resolutions */
		@media ( min-width:<?php echo get_option('bonfire_morph_smaller_than'); ?>px) and (max-width:<?php echo get_option('bonfire_morph_larger_than'); ?>px) {
			.morph-main-menu-button-wrapper,
			.morph-main-wrapper,
			.morph-main-background,
			.morph-background-overlay { display:none; }
			body { margin-top:0; }
		}
		</style>
		<!-- END CUSTOM COLORS (WP THEME CUSTOMIZER) -->
	
	<?php
	}
	add_action('wp_footer','bonfire_morph_header_customize');

?>