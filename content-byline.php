<p class="byline">
	<span class="author vcard"><?php the_author_posts_link(); ?></span> <span class="sep">|</span> 
	<abbr class="published" title="<?php the_time(__('l, F jS, Y, g:i a', 'example')); ?>"><?php the_time(__('F j, Y', 'example')); ?></abbr>
	<?php edit_post_link(__('Edit', 'example'), ' <span class="sep">|</span> <span class="edit">', '</span> '); ?>
</p>