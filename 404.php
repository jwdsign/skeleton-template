<?php get_header(); ?>

<div id="main" role="main">

<div class="container">

		<h2>Diese Seite gibt es nicht... (Error 404)</h2>

		<p>Aber vielleicht können wir Ihnen weiterhelfen:</p>
		<?php 
			$s = preg_replace("/(.*)-(html|htm|php|asp|aspx)$/","$1",$wp_query->query_vars['name']);
			$posts = query_posts('post_type=any&name='.$s);
			$s = str_replace("-"," ",$s);
			if (count($posts) == 0) {
				$posts = query_posts('post_type=any&s='.$s);
			}
			if (count($posts) > 0) {
				echo "<ol><li>";
				echo "<p>Haben Sie vielleicht nach einer der folgenden Seiten gesucht?</p>";
				echo "<ul>";
				foreach ($posts as $post) {
					echo '<li><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></li>';
				}
				echo "</ul>";
				echo "<p>Wenn nicht, haben wir hier noch ein paar weitere Tipps für Sie:</p></li>";
			} else {
				echo "<p><i>Die automatische Suche ergab leider <strong>keinen Treffer.</strong></i></p>";
				echo "<p><strong>Keine Angst!</strong> Hier noch ein paar Ideen, um die gesuchte Seite zu finden:</p>";
				echo "<ol>";
			}
		?>
			<li>
				<label for="s"><strong>Suchen</strong> Sie danach:</label>
				<form style="display:inline;" action="<?php bloginfo('siteurl');?>">
					<input type="text" value="<?php echo esc_attr($s); ?>" id="s" name="s"/> <input type="submit" value="Search"/>
				</form>
			</li>
			<li>
				<strong>Wenn Sie die Adresse direkt eingegeben haben...</strong> stellen Sie sicher, dass Rechtschreibung, GROSS- und kleinschreibung beachtet wurden. Versuchen Sie dann, die Seite neu zu laden.
				
			</li>
			<li>
				<strong>Suchen Sie</strong> in der <a href="<?php bloginfo('siteurl');?>/sitemap/">Sitemap</a>.
				
			</li>
			<li>
				Kehren Sie zur <a href="<?php bloginfo('siteurl');?>">Startseite</a> zurück (und schreiben Sie uns bitte eine E-Mail, so dass wir den Fehler beheben können).
			</li>
		</ol>

</div>

<?php get_footer(); ?>