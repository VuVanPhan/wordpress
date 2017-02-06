<?php
//use vars
//$collection from parent template
$collection = $this->getCollection();

$company = \SoictApp::helper('user')->getCurrentUser();

$grid_url = get_site_url('', 'company/internships');
?>
<?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>
<div class="internship list-wrap">
    <div class="row-header"><h3><?php echo __('Danh sách các chương trình thực tập') ?></h3></div>

    <div class="table-wrap">
        <form action="<?php echo $grid_url ?>" method="get">
            <?php if (file_exists($view = \SoictApp::getView('toolbar/paging.php'))) include $view ?>

            <table class="soict-table">
                <colgroup>
                    <col width="50"/>
                    <col width="250"/>
                    <col width="330"/>
                    <col width="110"/>
                    <col width="110"/>
                    <col width="120"/>
                    <col width="120"/>
                    <col width="100"/>
                </colgroup>
                <thead>
                <tr>
                    <th><?php echo __('STT') ?></th>
                    <th><?php echo __('Tên kỳ thực tập') ?></th>
                    <th><?php echo __('Nội dung') ?></th>
                    <th><?php echo __('Bắt đầu ngày') ?></th>
                    <th><?php echo __('Kết thúc ngày') ?></th>
                    <th><?php echo __('Điện thoại hỗ trợ') ?></th>
                    <th><?php echo __('Email liên hệ') ?></th>
                    <th><?php echo __('') ?></th>
                </tr>
                </thead>
                <tbody>

                <?php $count = 1; ?>
                <?php foreach($collection as $item): ?>
                    <tr>
                        <td><?php echo $count ?></td>
                        <td><?php echo $item->getTitle() ?></td>
                        <td><?php echo $item->getDescription() ?></td>
                        <td><?php echo $item->getFromDate() ?></td>
                        <td><?php echo $item->getToDate() ?></td>
                        <td><?php echo $item->getSupportPhone() ?></td>
                        <td><?php echo $item->getSupportEmail() ?></td>
                        <td>
                            <?php if( $company->isRegisteredInternship($item->getId()) ): ?>
                                <span class="fade-text registered"><?php echo __('Đã đăng ký') ?></span>
                            <?php else: ?>
                                <a class="button-link register"
                                   href="<?php echo $grid_url ?>/registering?internship=<?php echo $item->getId() ?>"><?php echo __('Đăng ký') ?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php $count++; ?>
                <?php endforeach; ?>

                </tbody>
            </table>

            <button type="submit" style="display: none;">Submit</button>
        </form>

    </div>

</div>
