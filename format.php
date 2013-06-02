<?php get_header(); ?>

<div id="main" role="main">

<?php the_content(); ?>
<?php comments_template( '', true ); ?>

</div>

<?php get_footer(); ?>