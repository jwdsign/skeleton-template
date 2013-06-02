<nav id="mobile-menu" role="nav">
	<h2>Navigation</h2>
	<?php if ( has_nav_menu( 'mobile_menu' ) ) { ?>
	<?php $defaults = array(
	  'theme_location'  => 'mobile_menu',
	  'menu'            => '', 
	  'container'       => false, 
	  'echo'            => true,
	  'fallback_cb'     => false,
	  'items_wrap'      => '<ul id="%1$s"> %3$s</ul>',
	  'depth'           => 0 );
	  wp_nav_menu( $defaults );
	?>
<?php } else { ?>
	<ul>
	  <?php wp_list_pages('title_li='); ?>
	</ul>
<?php } ?>
	
</nav>