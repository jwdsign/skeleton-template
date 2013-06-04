<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php the_title('<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h2>'); ?>

<?php get_template_part( 'content', 'byline' ); ?>

<div class="entry-content">
	<?php the_content(__('Continue reading', 'example')); ?>
	<?php wp_link_pages('before=<p class="pages">' . __('Pages:','example') . '&after=</p>'); ?>
</div>

<?php get_template_part( 'content', 'meta' ); ?>
</article>