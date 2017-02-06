<?php
//use vars
?>
<?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>

<div class="soict internship student-edit">
    <?php if ($this->getStudent() && $this->getInternship()): ?>
        <?php
        $url = get_site_url('', 'company/my-internships/students/edit?student='.$_GET['student'].'&internship='.$_GET['internship']);
        $studentDownloadUrl = get_site_url('', 'company/my-internships/students/downloadfile?type=student&student='.$_GET['student'].'&internship='.$_GET['internship']);
        $companyDownloadUrl = get_site_url('', 'company/my-internships/students/downloadfile?type=company&student='.$_GET['student'].'&internship='.$_GET['internship']);

        $internshipStudent = $this->getInternshipStudent();

        ?>
        <div class="row-header">
            <h3><?php echo __('Xem & Đánh giá sinh viên thực tập') ?></h3>
            <?php if ($this->getInternship()): ?>
            <h3><?php echo __('khóa thực tập "'.$this->getInternship()->getTitle().'"') ?></h3>
            <?php endif; ?>
        </div>

        <div class="form-wrap">

            <div class="person-info">
                <?php if ($this->getStudent()->getUserPhoto()): ?>
                    <img src="<?php echo $this->getStudent()->getUserPhoto() ?>"
                         title="<?php echo $this->getStudent()->getName() ?>" alt="ảnh đại diện"/>
                <?php endif; ?>
            </div>

            <div class="person-info name"><?php echo __('Sinh viên:') ?><span class="value"><?php
                    echo $this->getStudent()->getName()
                ?></span>
            </div>

            <form action="<?php echo $url ?>" method="post" enctype="multipart/form-data">
                <div class="form-inner">

                    <?php if ($internshipStudent->getReportFile()): ?>
                    <div class="input-row">
                        <label for="report_file"><?php echo __('File báo cáo của sinh viên:') ?></label>
                        <div class="value">
                            <a id="report_file" class="button"
                               href="<?php echo $studentDownloadUrl ?>"><?php echo __('Tải về') ?></a>
                        </div>
                    </div>

                    <div class="input-row">
                        <label><?php echo __('Ngày báo cáo:') ?></label>
                        <div class="value value-right"><?php echo ($internshipStudent && $internshipStudent->getReportDate())
                                ? $internshipStudent->getReportDate() : __('Chưa báo cáo') ?></div>
                    </div>
                    <?php endif; ?>

                    <div class="input-row">
                        <label for="company_review_file"><?php echo __('Tải lên file đánh giá') ?></label>
                        <div class="value value-right">
                            <input type="file" id="company_review_file" name="company_review_file" />

                            <?php if($internshipStudent->getCompanyReviewFile()): ?>
                            <a id="com_review_file" class="button"
                               href="<?php echo $companyDownloadUrl ?>"><?php echo __('Tải về') ?></a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="input-row">
                        <label for="qty"><?php echo __('Viết đánh giá:') ?></label>
                        <textarea class="value" id="company_review_text" name="company_review_text"
                                  placeholder="<?php echo __('Văn bản đánh giá về sinh viên') ?>"
                        ><?php echo $internshipStudent->getCompanyReviewText() ?></textarea>
                    </div>

                    <div class="input-row">
                        <label for="company_points"><?php echo __('Chấm điểm sinh viên') ?></label>
                        <input type="text" class="text value" id="company_points"
                               name="company_points" value="<?php echo $internshipStudent->getCompanyPoints() ?>"
                               placeholder="<?php echo __('Điểm') ?>" />
                    </div>

                    <div class="input-row">
                        <button class="button-submit" type="submit" name="action" value="save"><?php echo __('Lưu đánh giá') ?></button>
                    </div>

                </div>
            </form>

        </div>

    <?php else: ?>
        <!--<div class="no-data"><?php /*echo __('Không tìm thấy dữ liệu') */?></div>-->
    <?php endif; ?>
</div>
