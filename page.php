<?php get_header(); ?>

<div id="main" role="main">

<div class="container"
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<h1><?php the_title(); ?></h1>
		
		<div class="page-content"><?php the_content(); ?></div>

<?php endwhile; ?>

<?php else : ?>

	<div>
		<h1>Keine Einträge gefunden</h1>
	</div>

<?php endif; ?>
</div>

</div>

<?php get_footer(); ?>