<?php
//use vars
$url = get_site_url('', 'student/myinfo');
?>

<?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>

<div class="soict student-edit">
    <div class="row-header">
        <h3><?php echo __('Chỉnh sửa thông tin cá nhân') ?></h3>
    </div>

    <div class="form-wrap">

        <div class="person-info photo">
            <?php if ($this->getStudent()->getUserPhoto()): ?>
                <img src="<?php echo $this->getStudent()->getUserPhoto() ?>"
                     title="<?php echo $this->getStudent()->getName() ?>" alt="ảnh đại diện"/>
            <?php endif; ?>
            <h3><span class="name"><?php echo $this->getStudent()->getName() ?></span></h3>
        </div>


        <form action="<?php echo $url ?>" method="post" enctype="multipart/form-data">
            <div class="form-inner">

                <div class="input-row">
                    <div class="col-left">
                        <label for="student_id"><?php echo __('MSSV') ?></label>
                    </div>
                    <div class="col-left">
                        <input type="text" id="student_id" name="student_id"
                               value="<?php echo $this->getStudent()->getStudentId() ?>" disabled="disabled" />
                    </div>
                </div>

                <div class="input-row">
                    <div class="col-left">
                        <label for="name"><?php echo __('Họ & Tên:') ?></label>
                    </div>
                    <div class="col-left">
                        <input type="text" id="name" name="name" value="<?php echo $this->getStudent()->getName() ?>" />
                    </div>
                </div>

                <div class="input-row">
                    <div class="col-left">
                        <label for="email"><?php echo __('Email:') ?></label>
                    </div>
                    <div class="col-left">
                        <input type="text" id="email" name="email" value="<?php echo $this->getStudent()->getEmail() ?>" />
                    </div>
                </div>

                <div class="input-row">
                    <div class="col-left">
                        <label for="telephone"><?php echo __('Số điện thoại:') ?></label>
                    </div>
                    <div class="col-left">
                        <input type="text" id="telephone" name="telephone"
                               value="<?php echo $this->getStudent()->getTelephone() ?>" />
                    </div>
                </div>

                <div class="input-row">
                    <div class="col-left">
                        <label for="address"><?php echo __('Địa chỉ:') ?></label>
                    </div>
                    <div class="col-left">
                        <input type="text" id="address" name="address"
                            value="<?php echo $this->getStudent()->getAddress() ?>"/>
                    </div>
                </div>

                <div class="input-row">
                    <div class="col-left">
                        <label for="gender"><?php echo __('Giới tính:') ?></label>
                    </div>
                    <div class="col-left">
                        <select id="gender" name="gender">
                            <option value=""><?php echo __('Chưa xác định') ?></option>
                            <option value="male" <?php echo ($this->getStudent()->getGender() == 'male')
                                ? 'selected':'' ?>><?php echo __('Nam') ?></option>
                            <option value="female" <?php echo ($this->getStudent()->getGender() == 'female')
                                ? 'selected':'' ?>><?php echo __('Nữ') ?></option>
                        </select>
                    </div>
                </div>

                <div class="input-row">
                    <div class="col-left">
                        <label for="birthday"><?php echo __('Ngày sinh:') ?></label>
                    </div>
                    <div class="col-left">
                        <input type="text" id="birthday" name="birthday"
                               value="<?php echo $this->getStudent()->getBirthday() ?>" placeholder="1970-12-30"/>
                    </div>
                </div>

                <div class="input-row">
                    <div class="col-left">
                        <label for="avatar"><?php echo __('Avatar: (120x120 PX)') ?></label>
                    </div>
                    <div class="col-left">
                        <input type="file" id="avatar" name="avatar" />
                    </div>
                </div>

                <div class="input-row">
                    <button class="button-submit" type="submit" name="action" value="save"><?php
                        echo __('Lưu thông tin') ?></button>
                </div>

            </div>

            <script type="text/javascript">
                $j = jQuery.noConflict();
                $j(document).ready(function(){
                    //$j('#birthday').datepicker({dateFormat: "yy-mm-dd"});
                });
            </script>

        </form>

    </div>
</div>
