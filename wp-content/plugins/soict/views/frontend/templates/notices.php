
<?php
$notice1 = $this->getNotice1();
$notice2 = $this->getNotice2();
$notice3 = $this->getNotice3();
?>

<div class="message registration-notice-1" <?php echo ($notice1) ? 'style="display: block;"':'style="display: none;"' ?>>
    <p><strong><?php echo __($notice1, 'Soict'); ?></strong></p></div>
<div class="message error registration-notice-2" <?php echo ($notice2) ? 'style="display: block;"':'style="display: none;"' ?>>
    <p><strong><?php echo __($notice2, 'Soict'); ?></strong></p></div>
<div class="message error registration-notice-3" <?php echo ($notice3) ? 'style="display: block;"':'style="display: none;"' ?>>
    <p><strong><?php echo __($notice3, 'Soict'); ?></strong></p></div>
