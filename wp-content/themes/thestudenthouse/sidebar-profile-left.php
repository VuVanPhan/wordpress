<?php //echo ThemexCore::getURL('profile-company');die(); ?>

<aside class="column twocol">
	<div class="user-image">			
		<div class="bordered-image thick-border">
			<?php echo get_avatar(ThemexUser::$data['user']['ID'], 200); ?>
		</div>
		<?php if(is_user_logged_in()) { ?>
		<div class="user-image-uploader">
			<form action="<?php echo themex_url(); ?>" enctype="multipart/form-data" method="POST">
				<label for="avatar" class="element-button"><span class="button-icon upload"></span><?php _e('Upload','academy'); ?></label>
				<input type="file" class="shifted" id="avatar" name="avatar" />
				<input type="hidden" name="user_action" value="update_avatar" />
				<input type="hidden" name="nonce" value="<?php echo wp_create_nonce(THEMEX_PREFIX.'nonce'); ?>" />
			</form>
		</div>
		<?php } ?>
	</div>
	<?php if(is_user_logged_in()) { ?>
	<div class="user-menu">
		<ul>
			<li <?php if(get_query_var('author')) { ?>class="current"<?php } ?>><a href="<?php echo ThemexUser::$data['user']['profile_url']; ?>">Thông tin</a></li>
			<li <?php if(get_query_var('profile-settings')) { ?>class="current"<?php } ?>><a href="<?php echo ThemexCore::getURL('profile-settings'); ?>">Settings</a></li>
			<!-- Harry Delete - My Order	
				<?php if(ThemexWoo::isActive()) { ?>
							<li <?php if(get_the_ID()==get_option('woocommerce_myaccount_page_id')) { ?>class="current"<?php } ?>><a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"><?php _e('My Orders','academy'); ?></a></li>
				<?php } ?>
			 End Delete -->
			<?php $user_id = ThemexUser::$data['user']['ID'] ?>
			<?php
				$caps = get_user_meta($user_id, 'wp_capabilities', true);
				$roles = array_keys((array)$caps);
				$role = '';
				if($roles[0])
					$role = $roles[0];
				if($role == 'business'){ ?>
					<li <?php if(get_query_var('profile-company')) { ?>class="current"<?php } ?>><a href="<?php echo get_site_url().'/?profile-company=1'; ?>"><?php _e('My Company','academy'); ?></a></li>
				<?php }
			?>
		</ul>
	</div>
	<?php } ?>
</aside>