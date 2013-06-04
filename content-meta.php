<p class="entry-meta">
	<span class="categories"><?php _e('Posted in', 'example'); ?> <?php the_category(', '); ?></span>
	<?php the_tags('<span class="tags"> <span class="sep">|</span> ' . __('Tagged', 'example') . ' ', ', ', '</span>'); ?> 


<?php if ( ! is_singular() ) {?>

	<span class="sep">|</span> <?php comments_popup_link(__('Leave a response', 'example'), __('1 Response', 'example'), __('% Responses', 'example'), 'comments-link', __('Comments closed', 'example')); ?> 

<?php }?>

</p>