<?php
/*
Template Name: Profile Settings
*/
?>
<?php
if(!get_current_user_id()){
	wp_redirect(get_site_url().'/register');
	return;
}
?>
<?php
	require_once('init/functions/student/student.php');
	$student = new Student();
	$programIds = $student->getAllProgramIds();
	$status = $student->getProgramStatus();
?>
<?php get_header(); ?>
<div class="user-profile">
	<?php get_sidebar('profile-left'); ?>
	<div class="column eightcol">
		<div class="message">
			<?php ThemexInterface::renderMessages(themex_value($_POST, 'success', false)); ?>
		</div>
		<div class="left"><h2><?php echo _e('List all your internship programs', 'academy'); ?></h2></div>
		<div class="clear"></div>
		<div>
			<table class="shop_table shop_table_responsive customer_details">
				<thead>
					<tr>
						<th class="program-id"><?php _e( 'ID', 'academy' ); ?></th>
						<th class="program-name"><?php _e( 'Name', 'academy' ); ?></th>
						<th class="program-course"><?php _e( 'Course', 'academy' ); ?></th>
						<th class="program-start"><?php _e( 'Start date', 'academy' ); ?></th>
						<th class="program-end"><?php _e( 'End date', 'academy' ); ?></th>
						<th class="program-status"><?php _e( 'Status', 'academy' ); ?></th>
						<th class="program-action"></th>
					</tr>
				</thead>
				<tbody>
					<?php if(!empty($programIds)): ?>
						<?php foreach($programIds as $program_id): ?>
							<?php $program = $student->getProgramData($program_id['internship_program_id']); ?>
							<?php
								if($program['status'] == 0 || $program['status'] == 4)
									continue;
							?>
							<tr>
								<td class="program-id"><?php echo $program['internship_program_id'] ?></td>
								<td class="program-name"><?php echo $program['name'] ?></td>
								<td class="program-course"><?php echo $program['course'] ?></td>
								<td class="program-start"><?php echo date('d/m/Y', strtotime($program['start_date'])); ?></td>
								<td class="program-end"><?php echo date('d/m/Y', strtotime($program['end_date'])); ?></td>
								<td class="program-status"><?php _e($status[$program['status']],'academy'); ?></td>
								<td class="program-action"><a href="<?php echo get_site_url().'/?university-edit-program='.$program['internship_program_id']; ?>"><?php _e('View', 'academy'); ?></a> </td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="7"><?php _e('You have not any internship program!', 'academy'); ?></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php //get_sidebar('profile-right'); ?>
</div>
<?php get_footer(); ?>