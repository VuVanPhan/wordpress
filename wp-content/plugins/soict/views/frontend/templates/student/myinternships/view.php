<?php
//use vars
$internship = $this->getInternship();
?>
<?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>

<div class="soict internship student-edit">
    <?php if ($internship): ?>
        <?php

        $internshipStudent = $this->getInternshipStudent();
        $student = $this->getStudent();
        $company = $this->getCompany();
        $lecturer = $this->getLecturer();

        $url = get_site_url('', 'student/myinternships/view');
        $studentDownloadUrl = get_site_url('', 'student/report/downloadfile?type=student&company='. $company->getId()
            . '&internship=' . $internshipStudent->getInternshipProgramId());

        ?>
        <div class="row-header">
            <h3><?php echo __('Thông tin thực tập của tôi') ?></h3>
            <?php if ($this->getInternship()): ?>
                <h3><?php echo __('khóa thực tập "'. $internship->getTitle().'"') ?></h3>
            <?php endif; ?>
        </div>

        <div class="form-wrap">

            <div class="person-info name"><?php echo __('Sinh viên:') ?><span class="value"><?php
                    echo $student->getName()
                    ?></span>
            </div>

            <div class="person-info company">
                <div class="person-row">
                    <div class="left-col"><?php echo __('Thực tập tại:') ?></div>
                    <div class="right-col company-name"><?php echo $company->getName() ?></div>
                </div>

                <div class="person-row">
                    <div class="left-col"><?php echo __('Địa chỉ:') ?></div>
                    <div class="right-col company-name"><?php echo $company->getAddress() ?></div>
                </div>

                <?php if($lecturer && $lecturer->getId()): ?>
                <div class="person-row">
                    <div class="left-col"><?php echo __('Giáo viên viên hướng dẫn:') ?></div>
                    <div class="right-col company-name"><?php echo $lecturer->getName() ?></div>
                </div>
                <?php endif; ?>

                <div class="person-row">
                    <div class="left-col"><?php echo __('Điểm công ty đánh giá:') ?></div>

                    <?php if ($companyPoints = $internshipStudent->getCompanyPoints()): ?>
                        <div class="right-col"><?php echo $companyPoints ?></div>
                    <?php else: ?>
                        <div class="right-col"><?php echo __('--') ?></div>
                    <?php endif; ?>
                </div>

                <div class="person-row">
                    <div class="left-col"><?php echo __('Điểm giáo viên đánh giá:') ?></div>

                    <?php if ($lecturerPoints = $internshipStudent->getLecturerPoints()): ?>
                        <div class="right-col"><?php echo $lecturerPoints ?></div>
                    <?php else: ?>
                        <div class="right-col"><?php echo __('--') ?></div>
                    <?php endif; ?>
                </div>

            </div>

            <form action="<?php echo $url ?>" method="post" enctype="multipart/form-data">
                <div class="form-inner">
                    <div class="input-row">
                        <label for="report_file"><?php echo __('Tải lên file báo cáo') ?></label>
                        <div class="value value-right">
                            <input type="file" id="report_file" name="report_file" />

                            <?php if($internshipStudent->getReportFile()): ?>
                                <a id="lec_review_file" class="download"
                                   href="<?php echo $studentDownloadUrl ?>"><?php echo __('Tải về') ?></a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="input-row submit-row">
                        <button class="button-submit student" type="submit" name="action" value="save"><?php echo __('Nộp báo cáo') ?></button>
                    </div>

                </div>
            </form>

        </div>

    <?php else: ?>
        <!--<div class="no-data"><?php /*echo __('Không tìm thấy dữ liệu') */?></div>-->
    <?php endif; ?>
</div>
