<?php
//use vars
//$collection from parent template
$collection = $this->getCollection();

$student = \SoictApp::helper('user')->getCurrentUser();

$grid_url = get_site_url('', 'student/myinternships');
?>
<?php if (\SoictApp::getView('notices.php')) include \SoictApp::getView('notices.php'); ?>
<div class="soict student myinternships list-wrap">
    <div class="row-header"><h3><?php echo __('Các kỳ thực tập tôi tham gia') ?></h3></div>

    <?php if ($collection->getSize()): ?>
    <div class="table-wrap">
        <form action="<?php echo $grid_url ?>" method="get">

            <table class="soict-table">
                <colgroup>
                    <col width="50"/>
                    <col width="350"/>
                    <!--<col width="330"/>-->
                    <col width="110"/>
                    <col width="110"/>
                    <!--<col width="120"/>
                    <col width="120"/>
                    <col width="50"/>-->
                    <col width="100"/>
                </colgroup>
                <thead>
                <tr>
                    <th><?php echo __('STT') ?></th>
                    <th><?php echo __('Kỳ thực tập') ?></th>
                    <!--<th><?php /*echo __('Nội dung') */?></th>-->
                    <th><?php echo __('Bắt đầu ngày') ?></th>
                    <th><?php echo __('Kết thúc ngày') ?></th>
                    <!--<th><?php /*echo __('Điện thoại hỗ trợ') */?></th>
                    <th><?php /*echo __('Email liên hệ') */?></th>
                    <th><?php /*echo __('Số lượng') */?></th>-->
                    <th><?php echo __('') ?></th>
                </tr>
                </thead>
                <tbody>

                <?php $count = 1; ?>
                <?php foreach($collection as $item): ?>
                    <tr>
                        <td><?php echo $count ?></td>
                        <td><a href="<?php echo $grid_url ?>/view?internship=<?php echo $item->getId() ?>"
                               title="<?php echo __('view internship detail') ?>"><?php
                                echo $item->getTitle() ?></a></td>
                        <!--<td><?php /*echo $item->getDescription() */?></td>-->
                        <td><?php echo $item->getFromDate() ?></td>
                        <td><?php echo $item->getToDate() ?></td>
                        <!--<td><?php /*echo $item->getSupportPhone() */?></td>
                        <td><?php /*echo $item->getSupportEmail() */?></td>
                        <td><?php /*echo $item->getStudentQty() */?></td>-->

                        <td></td>
                    </tr>
                    <?php $count++; ?>
                <?php endforeach; ?>

                </tbody>
            </table>

            <?php if (file_exists($view = \SoictApp::getView('toolbar/paging.php'))) include $view ?>

            <button type="submit" style="display: none;">Submit</button>
        </form>

    </div>
    <?php else: ?>
        <div class="soict-row row-footer no-internship"><h3><?php echo __('Chưa tham gia kỳ thực tập nào.') ?></h3></div>
    <?php endif; ?>

</div>
