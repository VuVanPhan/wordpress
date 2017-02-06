				<?php if(is_active_sidebar('footer')) { ?>
					<div class="clear"></div>
					<div class="footer-sidebar sidebar clearfix">
						<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer')); ?>
					</div>
				<?php } ?>
				</div>
			</div>
			<!-- /content -->
			<div class="footer-wrap">
				<footer class="site-footer">
					<div class="row">
						<!-- Edited by Harry - Begin -->
						<div style="text-align: center; width: 100%;">
							<span style="font-size:14px;"><span style="font-family: tahoma,geneva,sans-serif;">Copyright © 2013 Trang chủ Viện Công nghệ Thông tin và Truyền thông</span></span></div>
						<div style="text-align: center; width: 100%;margin-top:5px;">
							<span style="font-size:14px;"><a href="http://hust.edu.vn" style="font-family: tahoma, geneva, sans-serif; font-size: 16px;" target="_blank">Đại học Bách Khoa Hà Nội</a><span style="font-family: tahoma, geneva, sans-serif;"></span></span></div>
						<!-- Edited by Harry - End -->
						<!-- Harry Delete 
						<div class="copyright left">
							<?php echo ThemexCore::getOption('copyright', 'TheStudentHouse &copy; '.date('Y')); ?>
						</div>
						End Delete -->
						

						<!-- /navigation -->				
					</div>			
				</footer>				
			</div>
			<!-- /footer -->			
		</div>
		<!-- /site wrap -->
	<?php wp_footer(); ?>
	</body>
</html>