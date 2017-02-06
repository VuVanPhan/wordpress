<?php ThemexCourse::refresh($post->ID); ?>
<div class="course-preview <?php echo ThemexCourse::$data['status']; ?>-course">
	<div class="course-image">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('normal'); ?></a>
		<?php if(empty(ThemexCourse::$data['plans']) && ThemexCourse::$data['status']!='private') { ?>
		<div class="course-price product-price">
			<div class="price-text"><?php echo ThemexCourse::$data['price']['text']; ?></div>
			<div class="corner-wrap">
				<div class="corner"></div>
				<div class="corner-background"></div>
			</div>			
		</div>
		<?php } ?>
	</div>
	<div class="course-meta">
		<header class="course-header">
			<h5 class="nomargin">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php //the_title(); ?>
					<?php $title = get_the_title() ?>
					<?php if (strlen($title) <= 35): ?>
						<?php the_title(); ?>
					<?php else: ?>
						<?php
							$title = substr($title, 0, 35);
							if ($title != "") {
								if (!substr_count($title, " ")) return $title." ...";
								while (strlen($title) && ($title[strlen($title) - 1] != " ")) $title = substr($title, 0, -1);
								$title = substr($title, 0, -1)." ...";
							}
							echo $title;
						?>
					<?php endif; ?>
					</a>
			</h5>
			<?php if(!ThemexCore::checkOption('course_author')) { ?>
			<a href="<?php echo ThemexCourse::$data['author']['profile_url']; ?>" class="author"><?php echo ThemexCourse::$data['author']['profile']['full_name']; ?></a>
			<?php } ?>
		</header>
		<?php if(!ThemexCore::checkOption('course_popularity') || !ThemexCore::checkOption('course_rating')) { ?>
		<footer class="course-footer clearfix">
			<?php if(!ThemexCore::checkOption('course_popularity')) { ?>
			<div class="course-users left">
				<?php echo ThemexCore::getPostMeta($post->ID, 'course_popularity', '0'); ?>
			</div>
			<?php } ?>
			<?php if(!ThemexCore::checkOption('course_rating')) { ?>
			<?php get_template_part('module', 'rating'); ?>
			<?php } ?>
		</footer>
		<?php } ?>
	</div>
</div>