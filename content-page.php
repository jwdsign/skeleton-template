<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php the_title('<h1 class="page-title">' , '</h1>'); ?>

<div class="entry-content">
	<?php the_content(__('Continue reading', 'example')); ?>
	<?php wp_link_pages('before=<p class="pages">' . __('Pages:','example') . '&after=</p>'); ?>
</div>

</article>