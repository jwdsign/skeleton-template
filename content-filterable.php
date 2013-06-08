<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php the_title('<h1 class="page-title">' , '</h1>'); ?>

<div class="entry-content">
	
	<!-- filterable goodness begins here -->

		<?php
				 $terms = get_terms("tagportfolio");
				 $count = count($terms);
				 echo '<ul id="portfolio-filter">';
					echo '<li><a href="#all" title="">All</a></li>';
				 if ( $count > 0 ){
					
						foreach ( $terms as $term ) {
							
							$termname = strtolower($term->name);
							$termname = str_replace(' ', '-', $termname);
							echo '<li><a href="#'.$termname.'" title="" rel="'.$termname.'">'.$term->name.'</a></li>';
						}
				 }
				 echo "</ul>";
			?>
			
	
			<?php 
				$loop = new WP_Query(array('post_type' => 'project', 'posts_per_page' => -1));
				$count =0;
			?>
			
			<div id="portfolio-wrapper">
				<ul id="portfolio-list">
			
				<?php if ( $loop ) : 
					 
					while ( $loop->have_posts() ) : $loop->the_post(); ?>
					
						<?php
						$terms = get_the_terms( $post->ID, 'tagportfolio' );
								
						if ( $terms && ! is_wp_error( $terms ) ) : 
							$links = array();

							foreach ( $terms as $term ) 
							{
								$links[] = $term->name;
							}
							$links = str_replace(' ', '-', $links);	
							$tax = join( " ", $links );		
						else :	
							$tax = '';	
						endif;
						?>
						
						<?php $infos = get_post_custom_values('_url'); ?>
						
						<li class="portfolio-item one-third column <?php echo strtolower($tax); ?> all">
							<div class="thumb"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a></div>
							<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
							<p class="excerpt"><a href="<?php the_permalink() ?>"><?php echo get_the_excerpt(); ?></a></p>
							<p class="links"><a href="<?php echo $infos[0]; ?>" target="_blank">Live Preview &rarr;</a> <a href="<?php the_permalink() ?>">More Details &rarr;</a></p>
						</li>
						
					<?php endwhile; else: ?>
					 
					<li class="error-not-found"><?php get_template_part( 'content', 'noposts' ); ?></li>
						
				<?php endif; ?>
			

				</ul>

				<div class="clearboth"></div>
			
			</div> <!-- end #portfolio-wrapper-->
							
			
			<script>
				$j(document).ready(function() {	
					$j("#portfolio-list").filterable();
				});
			</script>
		

	<!-- filterable goodness ends here -->

	<?php wp_link_pages('before=<p class="pages">' . __('Pages:','example') . '&after=</p>'); ?>
</div>

</article>