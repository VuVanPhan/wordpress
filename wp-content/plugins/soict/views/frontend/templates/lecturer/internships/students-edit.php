<?php
//use vars
?>
<?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>

<div class="soict internship student-edit">
    <?php if ($this->getStudent() && $this->getInternship()): ?>
        <?php
        $url = get_site_url('', 'lecturer/internships/students/edit?student='.$_GET['student'].'&internship='.$_GET['internship']);
        $studentDownloadUrl = get_site_url('', 'lecturer/internships/students/downloadfile?type=student&student='.$_GET['student'].'&internship='.$_GET['internship']);
        $lecturerDownloadUrl = get_site_url('', 'lecturer/internships/students/downloadfile?type=lecturer&student='.$_GET['student'].'&internship='.$_GET['internship']);
        $companyDownloadUrl = get_site_url('', 'lecturer/internships/students/downloadfile?type=company&student='.$_GET['student'].'&internship='.$_GET['internship']);

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

            <div class="person-info company">
                <div class="person-row">
                    <div class="left-col"><?php echo __('Thực tập tại:') ?></div>
                    <div class="right-col"><?php echo $this->getCompany()->getName() ?></div>
                </div>

                <div class="person-row">
                    <div class="left-col"><?php echo __('Báo cáo của sinh viên:') ?></div>

                    <?php if ($internshipStudent->getReportFile()): ?>
                        <div class="right-col">
                            <a id="report_file" class="highlight"
                               href="<?php echo $studentDownloadUrl ?>"><?php echo __('Tải về') ?></a>
                        </div>
                    <?php else: ?>
                        <div class="right-col"><?php echo __('Chưa báo cáo') ?></div>
                    <?php endif; ?>

                </div>

                <?php if ($internshipStudent->getReportFile()): ?>
                    <div class="person-row">
                        <div class="left-col"><?php echo __('Ngày báo cáo:') ?></div>
                        <div class="right-col"><?php echo $internshipStudent->getReportDate() ?></div>
                    </div>
                <?php endif; ?>

                <div class="person-row">
                    <div class="left-col"><?php echo __('Đánh giá của công ty:') ?>&nbsp;
                        <?php if ($internshipStudent->getCompanyReviewFile()): ?>
                        <a id="report_file" class="highlight"
                          href="<?php echo $companyDownloadUrl ?>"
                          title="<?php echo __('File đánh giá của công ty') ?>"><?php echo __('Tải về') ?></a>
                        <?php endif; ?>
                    </div>

                    <?php if ($companyReview = $internshipStudent->getCompanyReviewText()): ?>
                        <div class="right-col company-review"><?php echo $companyReview ?></div>
                    <?php else: ?>
                        <div class="right-col"><?php echo __('Chưa đánh giá') ?></div>
                    <?php endif; ?>

                </div>

                <?php if ($internshipStudent->getCompanyReviewFile()): ?>
                <!--<div class="person-row">
                    <div class="left-col"><?php /*echo __('File đánh giá:') */?></div>
                    <div class="right-col">

                    </div>
                </div>-->
                <?php endif; ?>

                <div class="person-row">
                    <div class="left-col"><?php echo __('Điểm đánh giá:') ?></div>

                    <?php if ($companyPoints = $internshipStudent->getCompanyPoints()): ?>
                        <div class="right-col"><?php echo $companyPoints ?></div>
                    <?php else: ?>
                        <div class="right-col"><?php echo __('--') ?></div>
                    <?php endif; ?>
                </div>

            </div>

            <form action="<?php echo $url ?>" method="post" enctype="multipart/form-data">
                <div class="form-inner">
                    <div class="input-row">
                        <label for="lecturer_review_file"><?php echo __('Tải lên file đánh giá') ?></label>
                        <div class="value value-right">
                            <input type="file" id="lecturer_review_file" name="lecturer_review_file" />

                            <?php if($internshipStudent->getLecturerReviewFile()): ?>
                            <a id="lec_review_file" class="download"
                               href="<?php echo $lecturerDownloadUrl ?>"><?php echo __('Tải về') ?></a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="input-row">
                        <label for="qty"><?php echo __('Viết đánh giá:') ?></label>
                        <textarea class="value" id="lecturer_review_text" name="lecturer_review_text"
                                  placeholder="<?php echo __('Văn bản đánh giá về sinh viên') ?>"
                        ><?php echo $internshipStudent->getLecturerReviewText() ?></textarea>
                    </div>

                    <div class="input-row">
                        <label for="lecturer_points"><?php echo __('Chấm điểm sinh viên') ?></label>
                        <input type="text" class="text value" id="lecturer_points"
                               name="lecturer_points" value="<?php echo $internshipStudent->getLecturerPoints() ?>"
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
