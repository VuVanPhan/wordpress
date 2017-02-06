<?php
//use vars
//$collection from parent template
$collection = $this->getCollection();

$company = \SoictApp::helper('user')->getCurrentUser();

$grid_url = get_site_url('', 'company/my-internships/students');
?>
<?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>

<div class="internship list-wrap">
    <?php if ($collection): ?>

    <div class="row-header">
        <h3><?php echo __('Danh sách các sinh viên đã đăng ký vào thực tập') ?></h3>
        <?php if ($this->getInternship()): ?>
        <h3><?php echo __('khóa thực tập "'.$this->getInternship()->getTitle().'"') ?></h3>
        <?php endif; ?>
    </div>

    <div class="table-wrap">
        <form action="<?php echo $grid_url ?>" method="get">
            <?php if (file_exists($view = \SoictApp::getView('toolbar/paging.php'))) include $view ?>

            <table class="soict-table">
                <colgroup>
                    <col width="50"/>
                    <col width="120"/>
                    <col width="220"/>
                    <col width="120"/>
                    <col width="250"/>
                    <col width="120"/>
                    <col width="120"/>
                    <col width="120"/>
                    <col width="100"/>
                </colgroup>
                <thead>
                <tr>
                    <th><?php echo __('STT') ?></th>
                    <th><?php echo __('MSSV') ?></th>
                    <th><?php echo __('Tên') ?></th>
                    <th><?php echo __('Ngày đăng ký') ?></th>
                    <th><?php echo __('Email') ?></th>
                    <th><?php echo __('Số điện thoại') ?></th>
                    <th><?php echo __('Điểm đánh giá') ?></th>
                    <th><?php echo __('Tổng điểm') ?></th>
                    <th><?php echo __('') ?></th>
                </tr>
                </thead>
                <tbody>

                <?php if ($collection->getSize()): ?>
                <?php $count = 1; ?>
                <?php foreach($collection as $item): ?>
                    <?php $student = $this->getStudent($item->getStudentId()) ?>
                    <tr>
                        <td><?php echo $count ?></td>
                        <td><a href="<?php echo $grid_url ?>/edit?student=<?php echo $student->getId() ?>&internship=<?php echo $this->getInternship()->getId() ?>"
                               title="<?php echo __('Click xem hoặc đánh giá sinh viên') ?>"><?php echo $student->getStudentId() ?></a></td>
                        <td><?php echo $student->getName() ?></td>
                        <td><?php echo $item->getRegisterDate() ?></td>
                        <td><?php echo $student->getEmail() ?></td>
                        <td><?php echo $student->getTelephone() ?></td>
                        <td><?php echo ($item->getCompanyReviewText() || $item->getCompanyReviewFile())
                                ? $item->getCompanyPoints() : '--' ?></td>
                        <td><?php echo $item->getTotalPoints() ?></td>
                        <td>
                            <?php if( $item->getReportFile() ): ?>
                                <span class="fade-text registered"><?php echo __('Đã nộp báo cáo') ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php $count++; ?>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" align="center"><?php echo __('Chưa có sinh viên đăng ký') ?></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <button type="submit" style="display: none;">Submit</button>
        </form>

    </div>

    <?php else: ?>
        <!--<div class="no-data"><?php /*echo __('Không tìm thấy dữ liệu') */?></div>-->
    <?php endif; ?>
</div>
