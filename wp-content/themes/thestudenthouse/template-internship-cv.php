<?php
/*
Template Name: Profile Settings
*/
?>
<?php
if (!get_current_user_id()) {
    wp_redirect(get_site_url() . '/register');
    return;
}
require_once('init/functions/student/student.php');
defined('BASE_PATH') || define('BASE_PATH', dirname(__FILE__) . '/');
$student = new Student();


if (isset($_FILES['import_file'])) {
    $reportFile = $_FILES['import_file'];


    if (($reportFile['name'] || $reportFile['name']) && in_array(pathinfo($reportFile['name'], PATHINFO_EXTENSION), array('xls', 'xlsx'))) {
        $target_path = BASE_PATH. '/init/lib/PHPExcel/tmp/' . basename($reportFile['name']);

        if (move_uploaded_file($reportFile['tmp_name'], $target_path)) {
            // Load PHPExcel
            require_once 'init/lib/PHPExcel/PHPExcel.php';
            $objPHPExcel = PHPExcel_IOFactory::load($target_path, true, "UTF-8");
            $sheetData = $objPHPExcel->getActiveSheet()->toArray();
            foreach ($sheetData as $row) {
                if (isset($row[0]) && isset($row[1])) {
                    $mssv = $row[0];
                    $password = $row[1];
                    $studentName = $row[2];
                    $id = wp_create_user($mssv, $password);

                    update_user_meta($id, 'student_name', sanitize_text_field($studentName));
                }
            }
            ThemexInterface::$messages[] = __('Đã Import Thành Công!', 'academy');
            $_POST['success'] = true;
            //					}
        } else {
            ThemexInterface::$messages[] = __('An error when upload!', 'academy');
            $_POST['success'] = false;
        }

    } else {
        ThemexInterface::$messages[] = __('Please import xls, xlsx file!', 'academy');
        $_POST['success'] = false;
    }


}

?>

<?php get_header(); ?>
    <div class="message">
        <?php ThemexInterface::renderMessages(themex_value($_POST, 'success', false)); ?>
    </div>
    <h1>Import sinh viên</h1>
    <p>Tải mẫu import tại <a href="<?php echo get_stylesheet_directory_uri().'/init/files/student/import_student.xlsx'; ?>">Đây</a></p>
    <br /><br />
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <div>
                <input type="file" class="form-control-file" id="exampleInputFile" name="import_file"
                       aria-describedby="fileHelp">
                <small id="fileHelp" class="form-text text-muted">Chọn file</small>
            </div>

        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
<?php get_footer(); ?>