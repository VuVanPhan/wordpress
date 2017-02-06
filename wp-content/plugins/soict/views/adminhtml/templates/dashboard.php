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
        printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', __( "Dashboard", "Soict" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=soict-internship' ), __( "Internships", "Soict" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=soict-student' ), __( "Students", "Soict" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=soict-company' ), __( "Companys", "Soict" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=soict-lecturer' ), __( "Lecturers", "Soict" ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=soict-setting' ), __( "Settings", "Soict" ) );
        ?>
    </h2>

    <div class="soict-dashboard">
        <div class="container">
            <div class="row">
                <div class="col-md-3 student-col">
                    <h4><?php echo __( "Student" ); ?></h4>
                    <div class="box-middle">
                        <p><?php echo $this->getStudentCount() ?></p>
                    </div>

                </div>
                <div class="col-md-3 company-col">
                    <h4><?php echo __( "Company" ); ?></h4>
                    <div class="box-middle">
                        <p><?php echo $this->getCompanyCount() ?></p>
                    </div>

                </div>
                <div class="col-md-3 lecturer-col">
                    <h4><?php echo __( "Lecturer" ); ?></h4>
                    <div class="box-middle">
                        <p><?php echo $this->getLecturerCount() ?></p>
                    </div>

                </div>
                <div class="col-md-3 internship-col">
                    <h4><?php echo __( "Internship" ); ?></h4>
                    <div class="box-middle">
                        <p><?php echo $this->getInternshipCount() ?></p>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <div class="avada-thanks">
        <p class="description"><?php echo __( "Thank you for choosing Soict. We are honored and are fully dedicated to making your experience perfect.", "Soict" ); ?></p>
    </div>
</div>
