<section id="subpages">
	<?php $this_page_id=$wp_query->post->ID; ?>
    <?php query_posts(array('showposts' => 20, 'post_parent' => $this_page_id, 'post_type' => 'page')); while (have_posts()) { the_post(); ?>
   	<!-- what we want to show of the child pages goes here ... -->
	<?php } ?>
</section>