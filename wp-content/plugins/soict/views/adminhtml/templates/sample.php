<?php

?>
<div class="wrap about-wrap avada-wrap">
    <h1><?php echo __( "Welcome to Soict!", "Soict" ); ?></h1>

    <div class="updated registration-notice-1" style="display: none;"><p><strong><?php echo __( "", "Soict" ); ?> </strong></p></div>

    <div class="updated error registration-notice-2" style="display: none;"><p><strong><?php echo __( "", "Soict" ); ?>.</strong></p></div>

    <div class="updated error registration-notice-3" style="display: none;"><p><strong><?php echo __( "", "Soict" ); ?></strong></p></div>

    <div class="about-text"><?php echo __( "Soict is now installed and ready to use!  Get ready to build something successfully. Please contact mrthinlt@gmail.com to get support and updates. Read below for additional information. We hope you enjoy it! <a href='//www.youtube.com/embed/dn6g_gJDAIk?rel=0&TB_iframe=true&height=540&width=960' class='thickbox' title='Guided Tour of Soict'>Watch Our Quick Guided Tour!</a>", "Soict" ); ?></div>
    <div class="avada-logo"><span class="avada-version"><?php echo __( "Version", "Soict" ); ?> <?php echo SOICT_VERSION; ?></span></div>
    <h2 class="nav-tab-wrapper">
        <?php
        printf( '<a href="%s" class="nav-tab nav-tab-active">%s</a>', admin_url( 'admin.php?page=soict' ), __( "Internships", "Soict" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=soict-student' ), __( "Student Manage", "Soict" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=soict-company' ), __( "Company Manage", "Soict" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=soict-lecturer' ), __( "Lecturer Manage", "Soict" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=soict-setting' ), __( "Settings", "Soict" ) );
        ?>
    </h2>

    <div class="avada-registration-steps">
        <div class="feature-section col three-col">
            <div class="col">
                <h4><?php echo __( "Step 1 - Signup for Support", "Soict" ); ?></h4>
                <p></p>
            </div>
            <div class="col">
                <h4><?php echo __( "Step 2 - Generate an API Key", "Soict" ); ?></h4>
                <p></p>
            </div>
            <div class="col last-feature">
                <h4><?php echo __( "Step 3 - Purchase Validation", "Soict" ); ?></h4>
                <p></p>
            </div>
        </div>

    </div>
    <div class="feature-section">
        <div class="avada-important-notice registration-form-container">
            <div class="avada-registration-form">
                <form id="avada_product_registration">
                    <input type="hidden" name="action" value="avada_update_registration" />
                    <input type="text" name="tf_username" id="tf_username" placeholder="<?php echo __( "Themeforest Username", "Soict" ); ?>" value="" />
                    <input type="text" name="tf_purchase_code" id="tf_purchase_code" placeholder="<?php echo __( "Enter Themeforest Purchase Code", "Soict" ); ?>" value="" />
                    <input type="text" name="tf_api" id="tf_api" placeholder="<?php echo __( "Enter API Key", "Avada" ); ?>" value="" />
                </form>
            </div>
            <button class="button button-large button-primary avada-large-button avada-register"><?php echo __( "Submit", "Soict" ); ?></button>
            <span class="avada-loader"><i class="dashicons dashicons-update loader-icon"></i><span></span></span>
        </div>
    </div>
    <div class="avada-thanks">
        <p class="description"><?php echo __( "Thank you for choosing Soict. We are honored and are fully dedicated to making your experience perfect.", "Soict" ); ?></p>
    </div>
</div>
