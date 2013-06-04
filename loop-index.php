<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

<?php get_template_part( 'content' ); ?>

<?php endwhile; ?>

<?php else : ?>

<?php get_template_part( 'content', 'noposts' ); ?>

<?php endif; ?>