    <?php  
    /* 
    Template Name: Filterable 
    */  
    ?>  
<?php get_header(); ?>

<div class="container">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
<?php get_template_part( 'content', 'filterable' ); ?>		

<?php endwhile; ?>

<?php get_template_part( 'content', 'nexpost' ); ?>

<?php else : ?>

<?php get_template_part( 'content', 'noposts' ); ?>

<?php endif; ?>
</div>

<?php get_footer(); ?>