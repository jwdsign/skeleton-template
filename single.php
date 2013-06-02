<?php get_header(); ?>

<div id="main" role="main">

<div class="container">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<?php the_content(); ?>
	</div>

<?php endwhile; ?>

	<div class="navigation">
		<div class="next-posts"><?php next_posts_link(); ?></div>
		<div class="prev-posts"><?php previous_posts_link(); ?></div>
	</div>

	<?php comments_template( '', true ); ?>

<?php else : ?>

	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h1>Keine Einträge gefunden</h1>
	</div>

<?php endif; ?>
</div>

</div>

<?php get_footer(); ?>