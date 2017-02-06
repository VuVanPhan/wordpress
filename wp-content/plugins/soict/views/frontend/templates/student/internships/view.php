<?php
//use vars
//$collection from parent template
$collection = $this->getCollection();

$student = \SoictApp::helper('user')->getCurrentUser();

$grid_url = get_site_url('', 'student/internships/view');
?>
<?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>

<?php if($collection): ?>
<div class="student internship company list-wrap">
    <div class="row-header"><h3><?php echo __('Các công ty thực tập') ?></h3></div>

    <div class="table-wrap">
        <form action="<?php echo $grid_url ?>" method="get">

            <table class="soict-table">
                <colgroup>
                    <col width="50"/>
                    <col width="100"/>
                    <col width="260"/>
                    <!--<col width="120"/>-->
                    <col width="300"/>
                    <!--<col width="120"/>
                    <col width="120"/>-->
                    <col width="100"/>
                    <col width="100"/>
                </colgroup>
                <thead>
                <tr>
                    <th><?php echo __('STT') ?></th>
                    <th><?php echo __('') ?></th>
                    <th><?php echo __('Tên công ty') ?></th>
                    <!--<th><?php /*echo __('Nội dung') */?></th>-->
                    <th><?php echo __('Địa chỉ') ?></th>
                    <!--<th><?php /*echo __('Điện thoại hỗ trợ') */?></th>
                    <th><?php /*echo __('Email liên hệ') */?></th>-->
                    <th><?php echo __('Số lượng đã Đ.K') ?></th>
                    <th><?php echo __('') ?></th>
                </tr>
                </thead>
                <tbody>

                <?php if ($collection && $collection->getSize()): ?>
                <?php $count = 1; ?>
                <?php foreach($collection as $item): ?>
                    <tr>
                        <td><?php echo $count ?></td>
                        <td><img class="company-logo" src="<?php echo get_site_url('', $item->getLogo()) ?>" width="80" alt="company logo"/></td>
                        <td><a href="#"><?php echo $item->getName() ?></a>
                        </td>
                        <td><?php echo $item->getAddress() ?></td>
                        <td><?php echo $item->getRegisteredQty() .'/'. $item->getStudentQty() ?></td>
                        <!--<td><?php /*echo $item->getSupportPhone() */?></td>
                        <td><?php /*echo $item->getSupportEmail() */?></td>
                        <td><?php /*echo $item->getStudentQty() */?></td>-->
                        <td>
                            <a class="button-link register"
                               href="<?php echo $grid_url ?>?internship=<?php
                               echo $this->getInternship()->getId() ?>&register-company=<?php
                               echo $item->getId() ?>"><?php echo __('Đăng ký') ?></a>
                        </td>
                    </tr>
                    <?php $count++; ?>
                <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;"><?php echo __('Không có dữ liệu') ?></td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>

            <?php if (file_exists($view = \SoictApp::getView('toolbar/paging.php'))) include $view ?>

            <button type="submit" style="display: none;">Submit</button>
        </form>

    </div>

</div>
<?php endif; ?>