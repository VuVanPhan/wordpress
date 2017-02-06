<div class="widget">
	<div class="widget-title">
		<?php $lessonData = ThemexLesson::getLesson($post->ID); ?>
		<?php $ID = $lessonData['course']; ?>
		<?php $post = get_post($ID); ?>
		<?php //var_dump(ThemexCourse::getCourse($courseID)) ?>
		<?php ThemexCourse::refresh($ID); ?>
<!--		<div class="course-item --><?php //if(ThemexCourse::$data['progress']!=100){ ?><!--started--><?php //} ?><!--">-->
<!--			<div class="course-title">-->
<!--				--><?php //if(ThemexCourse::$data['author']['ID']==ThemexUser::$data['active_user']['ID']) { ?>
<!--					<div class="course-status">--><?php //_e('Author', 'academy'); ?><!--</div>-->
<!--				--><?php //} ?>
				<h4 class="nomargin">
					<a href="<?php echo get_permalink($ID); ?>" style="color: #ffffff;">
						<strong><?php echo get_the_title($ID); ?></strong>						
					</a>
				</h4>
				<?php if(!in_array(ThemexCourse::$data['progress'], array(-1, 101))) { ?>
					<?php $totalLesson = count(ThemexCourse::$data['lessons']); ?>
					<?php $number = 0; ?>
					<?php $user_id = get_current_user_id(); ?>
					<?php foreach(ThemexCourse::$data['lessons'] as $les): ?>
						<?php if(ThemexCore::getUserRelations($user_id, $les->ID, 'lesson', true)): ?>
							<?php $number++; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php _e('Number of lessons completed:', 'academy')?><?php echo ' '.$number .'/'.$totalLesson?>
					<div class="clear"></div>
					<div class="course-progress">
						<span style="width:<?php echo ThemexCourse::$data['progress']; ?>%;"></span>
					</div>
				<?php } ?>
<!--			</div>-->
<!--		</div>-->
		<?php /*
		<h4 class="nomargin"><?php echo $post->post_title; //_e('Lessons', 'academy'); ?></h4>
 		*/ ?>
	</div>
	<div class="widget-content">
		<ul class="styled-list style-3">
			<?php foreach(ThemexCourse::$data['lessons'] as $lesson)	 { ?>
			<li class="<?php if($lesson->post_parent!=0) { ?>child<?php } ?> <?php if(ThemexLesson::getProgress($lesson->ID)==100) { ?>completed<?php } ?> <?php if($lesson->ID==ThemexLesson::$data['ID']) { ?>current<?php } ?>">
				<a href="<?php echo get_permalink($lesson->ID); ?>"><?php echo get_the_title($lesson->ID); ?></a>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>