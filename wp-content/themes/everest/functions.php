<?php

// Remove old copyright text
add_action( 'init' , 'everest_remove_copy' , 15 );
function everest_remove_copy() {
        remove_action( 'attitude_footer', 'attitude_footer_info', 30 );
}

// Add my own copyright text
add_action( 'attitude_footer' , 'everest_footer_info' , 30 );
function everest_footer_info() {
   $output = '<div class="copyright">'.'Copyright © 2016 Everest Mattress - Developed by: <a href="http://www.spyderbit.com">SpiderBit Computing</a>'.'</div><!-- .copyright -->';
   echo do_shortcode( $output );
}

// Remove old attitude_headerdetails
add_action( 'init', 'everest_remove_headerdetails', 5 );
function everest_remove_headerdetails() {
	remove_action( 'attitude_header', 'attitude_headerdetails', 10 );
}

// Add customized everest_headerdetails
add_action( 'attitude_header', 'everest_headerdetails', 10 );
function everest_headerdetails() {

		global $attitude_theme_options_settings;
   	$options = $attitude_theme_options_settings;

   	$elements = array();
		$elements = array( 	$options[ 'social_facebook' ], 
									$options[ 'social_twitter' ],
									$options[ 'social_googleplus' ],
									$options[ 'social_linkedin' ],
									$options[ 'social_pinterest' ],
									$options[ 'social_youtube' ],
									$options[ 'social_vimeo' ],
									$options[ 'social_flickr' ],
									$options[ 'social_tumblr' ],
									$options[ 'social_myspace' ],
									$options[ 'social_rss' ]
							 	);	

		$flag = 0;
		if( !empty( $elements ) ) {
			foreach( $elements as $option) {
				if( !empty( $option ) ) {
					$flag = 1;
				}
				else {
					$flag = 0;
				}
				if( 1 == $flag ) {
					break;
				}
			}
		}
	?>

	<div class="container clearfix">
		<div class="hgroup-wrap clearfix">
			<?php 
				if( 0 == $options[ 'hide_header_searchform' ] || 1 == $flag ) {
			?>
					<section class="hgroup-right">
						<?php attitude_socialnetworks( $flag ); ?>
						<?php $output = "<div><p style=\"text-align: right;\">Monday - Friday 10 AM to 5 PM<br />Saturday 9 AM to 4 PM<br />Sunday 11 Am to 4 PM</p></div>";
						echo do_shortcode( $output );
						?>
						
					</section><!-- .hgroup-right -->	
			<?php
				}
			?>
				<hgroup id="site-logo" class="clearfix">
					<?php 
						if( $options[ 'header_show' ] != 'disable-both' && $options[ 'header_show' ] == 'header-text' ) {
						?>
							<h1 id="site-title"> 
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
									<?php bloginfo( 'name' ); ?>
								</a>
							</h1>
							<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
						<?php
						}
						elseif( $options[ 'header_show' ] != 'disable-both' && $options[ 'header_show' ] == 'header-logo' ) {
						?>
							<h1 id="site-title"> 
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
									<img src="<?php echo $options[ 'header_logo' ]; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
								</a>
							</h1>
						<?php
						}
						?>
					
				</hgroup><!-- #site-logo -->
			
		</div><!-- .hgroup-wrap -->
	</div><!-- .container -->	
	<?php $header_image = get_header_image();
			if( !empty( $header_image ) ) :?>
				<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			<?php endif; ?>	
	<?php
		if ( has_nav_menu( 'primary' ) ) { 
			$args = array(
				'theme_location'    => 'primary',
				'container'         => '',
				'items_wrap'        => '<ul class="root">%3$s</ul>' 
			);
			echo '<nav id="access" class="clearfix">
					<div class="container clearfix">';
				wp_nav_menu( $args );
			echo '</div><!-- .container -->
					</nav><!-- #access -->';
		}
		else {
			echo '<nav id="access" class="clearfix">
					<div class="container clearfix">';
				wp_page_menu( array( 'menu_class'  => 'root' ) );
			echo '</div><!-- .container -->
					</nav><!-- #access -->';
		}
	?> 		
		<?php	
		if( 'above-slider' == $options[ 'slogan_position' ] &&  ( is_home() || is_front_page() ) ) 
			if( function_exists( 'attitude_home_slogan' ) )
				attitude_home_slogan(); 

		if( is_home() || is_front_page() ) {
			if( "0" == $options[ 'disable_slider' ] ) {
				if( function_exists( 'attitude_pass_cycle_parameters' ) ) 
   				attitude_pass_cycle_parameters();
   			if( function_exists( 'attitude_featured_post_slider' ) ) 
   				attitude_featured_post_slider();
   		}
		}
		else { 
			if( ( '' != attitude_header_title() ) || function_exists( 'bcn_display_list' ) ) { 
		?>
			<div class="page-title-wrap">
	    		<div class="container clearfix">
	    			<?php
		    		if( function_exists( 'attitude_breadcrumb' ) )
						attitude_breadcrumb();
					?>
				   <h3 class="page-title"><?php echo attitude_header_title(); ?></h3><!-- .page-title -->
				</div>
	    	</div>
	   <?php
	   	}
		} 
		if( 'below-slider' == $options[ 'slogan_position' ] && ( is_home() || is_front_page() ) ) 
			if( function_exists( 'attitude_home_slogan' ) )
				attitude_home_slogan(); 

}

/**
 * Fuction to show the page content.
 */
function attitude_theloop_for_page() {
	global $post;

	if( have_posts() ) {
		while( have_posts() ) {
			the_post();

			do_action( 'attitude_before_post' );
?>
	<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<article>

			<?php do_action( 'attitude_before_post_header' ); ?>

  			<?php do_action( 'attitude_after_post_header' ); ?>

  			<?php do_action( 'attitude_before_post_content' ); ?>

  			<div class="entry-content clearfix">
    			<?php the_content(); ?>
    			<?php
    				wp_link_pages( array( 
						'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'attitude' ),
						'after'             => '</div>',
						'link_before'       => '<span>',
						'link_after'        => '</span>',
						'pagelink'          => '%',
						'echo'              => 1 
               ) );
    			?>
  			</div>

  			<?php 

  			do_action( 'attitude_after_post_content' );

  			do_action( 'attitude_before_comments_template' ); 

         comments_template(); 

         do_action ( 'attitude_after_comments_template' );

         ?>

		</article>
	</section>
<?php
			do_action( 'attitude_after_post' );

		}
	}
	else {
		?>
		<h1 class="entry-title"><?php _e( 'No Posts Found.', 'attitude' ); ?></h1>
      <?php
   }
}
	
