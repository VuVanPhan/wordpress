<?php
$internship = $this->getInternship();

?>
<?php if ($internship): ?>

    <?php $url = get_site_url('', 'company/internships/registering?internship='.$internship->getId()); ?>

    <?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>

    <?php if (!$this->hasRegistered()): ?>
        <div class="internship-register">
            <div class="row-header">
                <h3><?php echo __('Đăng ký nhận sinh viên thực tập cho kỳ thực tập "'.$internship->getTitle().'"') ?></h3>
            </div>

            <div class="form-wrap">
                <form action="<?php echo $url ?>" method="post">
                    <div class="form-inner">
                        <label for="qty"><?php echo __('Số lượng sinh viên') ?></label>

                        <input type="text" id="qty" name="qty" />

                        <button class="button-submit" type="submit"><?php echo __('Đăng ký') ?></button>
                    </div>
                </form>

            </div>

        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="internship-register no-data">
        <h3><?php echo __('Xin lỗi hệ thống không thể đăng ký') ?></h3>
    </div>
<?php endif; ?>