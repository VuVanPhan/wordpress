<?php
$internship = $this->getInternship();
?>
<?php if ($internship): ?>
    <?php $url = get_site_url('', 'company/internships/register?internship='.$internship->getId()); ?>
    <div class="internship-register">
        <div class="row-header">
            <h3><?php echo __('Đăng ký nhận sinh viên thực tập cho kỳ thực tập "'.$internship->getTitle().'"') ?></h3>
        </div>

        <div class="form-wrap">
            <form action="<?php echo $url ?>" method="post">

                <label for="qty"><?php echo __('Số lượng sinh viên') ?></label>

                <input type="text" id="qty" name="qty" />

                <button type="submit"><?php echo __('Đăng ký') ?></button>
            </form>

        </div>

    </div>
<?php else: ?>
    <div class="internship-register no-data">
        <h4><?php echo __('Xin lỗi hệ thống không thể đăng ký') ?></h4>
    </div>
<?php endif; ?>