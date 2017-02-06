<?php the_post(); ?>
<?php ThemexCourse::refresh($post->ID, true); ?>

<!--	<div class="course-header clearfix">-->
<!--		<div class="course-header-content">-->
<!--			<div class="container">-->
<!--				<div class="fxac course-header-wrapper">-->
<!--					<div class="flex">-->
<!--						<h1 class="course-title ellipsis" data-purpose="course-title">-->
<!--							--><?php //the_title(); ?>
<!--						</h1>-->
<!---->
<!--						--><?php //if(!ThemexCore::checkOption('course_popularity') || !ThemexCore::checkOption('course_rating')) { ?>
<!--<!--							<footer class="course-footer clearfix">-->-->
<!--								--><?php //if(!ThemexCore::checkOption('course_popularity')) { ?>
<!--<!--									<div class="course-users left">-->-->
<!--										--><?php //echo ThemexCore::getPostMeta($post->ID, 'course_popularity', '0'); ?>
<!--<!--									</div>-->-->
<!--								--><?php //} ?>
<!--								--><?php //if(!ThemexCore::checkOption('course_rating')) { ?>
<!--									--><?php //get_template_part('module', 'rating'); ?>
<!--								--><?php //} ?>
<!--<!--							</footer>-->-->
<!--						--><?php //} ?>
<!---->
<!--					</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!---->
<!--<style type="text/css">-->
<!--	.course-header {-->
<!--		border-bottom: 5px solid rgba(0,0,0,.2);-->
<!--		height: 65px;-->
<!--		position: relative;-->
<!--	}-->
<!--	.course-header-content {-->
<!--		background: #545454;-->
<!--		height: 60px;-->
<!--		position: absolute;-->
<!--		top: 0;-->
<!--		left: 0;-->
<!--		width: 100%;-->
<!--	}-->
<!---->
<!--	.course-header-wrapper {-->
<!--		height: 60px;-->
<!--	}-->
<!--	.course-title {-->
<!--		color: #FFF;-->
<!--		font-size: 24px;-->
<!--		margin: 10px 0;-->
<!--		line-height: 1.4;-->
<!--	}-->
<!--</style>-->
<!---->
<!--<div class="clear"></div>-->

<div class="threecol column">
<?php get_template_part('content', 'course-grid'); ?>
<?php if(ThemexCourse::hasMembers() || is_active_sidebar('course') || !empty(ThemexCourse::$data['sidebar'])) { ?>
	<div class="clear"></div>
	<aside class="sidebar column last">
		<?php
		echo do_shortcode(themex_html(ThemexCourse::$data['sidebar']));
		
		if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('course'));
		
		if(ThemexCourse::hasMembers()) {
			get_template_part('module', 'users');
		}
		?>
	</aside>
<?php } ?>
</div>
<?php /*
<?php if(ThemexCourse::hasMembers() || is_active_sidebar('course') || !empty(ThemexCourse::$data['sidebar'])) { ?>
<div class="six col column">
<?php } else { ?>
<div class="ninecol column last">
<?php } ?>
 */ ?>
<div class="ninecol column last">
	<div class="course-description widget <?php echo ThemexCourse::$data['status']; ?>-course">
		<div class="widget-title">
			<h4 class="nomargin"><?php _e('Description', 'academy'); ?></h4>
		</div>
		<div class="widget-content">
			<?php the_content(); ?>
			<footer class="course-footer">
				<?php get_template_part('module', 'form'); ?>
			</footer>
		</div>						
	</div>
</div>
<?php /*
<?php if(ThemexCourse::hasMembers() || is_active_sidebar('course') || !empty(ThemexCourse::$data['sidebar'])) { ?>
<aside class="sidebar threecol column last">
	<?php
	echo do_shortcode(themex_html(ThemexCourse::$data['sidebar']));
	
	if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('course'));
	
	if(ThemexCourse::hasMembers()) {
		get_template_part('module', 'users');
	}
	?>
</aside>
<?php } ?>
*/ ?>