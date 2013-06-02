<nav id="main_menu" role="navigation">
<?php if ( has_nav_menu( 'main_menu' ) ) { ?>
	<?php $defaults = array(
	  'theme_location'  => 'main_menu',
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