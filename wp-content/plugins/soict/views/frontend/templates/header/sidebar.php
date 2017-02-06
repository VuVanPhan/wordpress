<?php
add_action('soict_header', 'soict_avada_logo_header', 1);

function soict_avada_logo_header(){
    if(function_exists('soict_avada_logo')){
        soict_avada_logo();
    }
}

function soict_avada_logo(){
    /**
     * No need to proceed any further if no logo is set
     */
    if ( '' == Avada()->settings->get( 'logo' ) && '' == Avada()->settings->get( 'logo_retina' ) ) {
        return;
    }
    ?>

    <div class="soict-logo" data-margin-top="<?php echo intval( Avada()->settings->get( 'margin_logo_top' ) ); ?>px" data-margin-bottom="<?php echo intval( Avada()->settings->get( 'margin_logo_bottom' ) ); ?>px" data-margin-left="<?php echo intval( Avada()->settings->get( 'margin_logo_left' ) ); ?>px" data-margin-right="<?php echo intval( Avada()->settings->get( 'margin_logo_right' ) ); ?>px">
        <?php
        /**
         * avada_logo_prepend hook
         */
        do_action( 'avada_logo_prepend' );
        ?>
        <?php if ( Avada()->settings->get( 'logo' ) ) : ?>
            <a class="fusion-logo-link" href="<?php echo home_url(); ?>">
                <?php $logo_url = Avada_Sanitize::get_url_with_correct_scheme( Avada()->settings->get( 'logo' ) ); ?>

                <?php if ( Avada()->settings->get( 'retina_logo_width' ) && Avada()->settings->get( 'retina_logo_height' ) ) : ?>
                    <?php $logo_size['width']  = fusion_strip_unit( Avada()->settings->get( 'retina_logo_width' ) ); ?>
                    <?php $logo_size['height'] = fusion_strip_unit( Avada()->settings->get( 'retina_logo_height' ) ); ?>
                <?php else : ?>
                    <?php $logo_size['width']  = ''; ?>
                    <?php $logo_size['height'] = ''; ?>
                <?php endif; ?>

                <img src="<?php echo $logo_url; ?>" width="<?php echo $logo_size['width']; ?>" height="<?php echo $logo_size['height']; ?>" alt="<?php bloginfo( 'name' ); ?>" class="fusion-logo-1x fusion-standard-logo" />
                <?php $retina_logo = Avada()->settings->get( 'logo_retina' ); ?>
                <?php if ( $retina_logo ) : ?>
                    <?php $retina_logo = Avada_Sanitize::get_url_with_correct_scheme( $retina_logo ); ?>
                    <?php $style = 'style="max-height: ' . $logo_size['height'] . 'px; height: auto;"'; ?>
                    <img src="<?php echo $retina_logo; ?>" width="<?php echo $logo_size['width']; ?>" height="<?php echo $logo_size['height']; ?>" alt="<?php bloginfo('name'); ?>" <?php echo $style; ?> class="fusion-standard-logo fusion-logo-2x" />
                <?php else: ?>
                    <img src="<?php echo $logo_url; ?>" width="<?php echo $logo_size['width']; ?>" height="<?php echo $logo_size['height']; ?>" alt="<?php bloginfo('name'); ?>" class="fusion-standard-logo fusion-logo-2x" />
                <?php endif; ?>

                <!-- mobile logo -->
                <?php if ( Avada()->settings->get( 'mobile_logo' ) ) : ?>
                    <?php $mobile_logo = Avada_Sanitize::get_url_with_correct_scheme( Avada()->settings->get( 'mobile_logo' ) ); ?>

                    <img src="<?php echo $mobile_logo; ?>" alt="<?php bloginfo( 'name' ); ?>" class="fusion-logo-1x fusion-mobile-logo-1x" />

                    <?php $retina_logo = Avada()->settings->get( 'mobile_logo_retina' ); ?>
                    <?php if ( $retina_logo ) : ?>
                        <?php $retina_logo = Avada_Sanitize::get_url_with_correct_scheme( $retina_logo ); ?>
                        <?php if ( Avada()->settings->get( 'mobile_retina_logo_width' ) && Avada()->settings->get( 'mobile_retina_logo_height' ) ) : ?>
                            <?php $logo_size['width']  = fusion_strip_unit( Avada()->settings->get( 'mobile_retina_logo_width' ) ); ?>
                            <?php $logo_size['height'] = fusion_strip_unit( Avada()->settings->get( 'mobile_retina_logo_height' ) ); ?>
                        <?php else : ?>
                            <?php $logo_size['width']  = ''; ?>
                            <?php $logo_size['height'] = ''; ?>
                        <?php endif; ?>
                        <?php $style = 'style="max-height: ' . $logo_size['height'] . 'px; height: auto;"'; ?>

                        <img src="<?php echo $retina_logo; ?>" alt="<?php bloginfo('name'); ?>" <?php echo $style; ?> class="fusion-logo-2x fusion-mobile-logo-2x" />
                    <?php else: ?>
                        <img src="<?php echo Avada()->settings->get( 'mobile_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="fusion-logo-2x fusion-mobile-logo-2x" />
                    <?php endif; ?>
                <?php endif; ?>

                <!-- sticky header logo -->
                <?php if ( Avada()->settings->get( 'sticky_header_logo' ) && ( in_array( Avada()->settings->get( 'header_layout' ), array( 'v1', 'v2', 'v3' ) ) || ( ( in_array( Avada()->settings->get( 'header_layout' ), array( 'v4', 'v5' ) ) && Avada()->settings->get( 'header_sticky_type2_layout' ) == 'menu_and_logo' ) ) ) ) : ?>
                    <?php $sticky_logo = Avada_Sanitize::get_url_with_correct_scheme( Avada()->settings->get( 'sticky_header_logo' ) ); ?>
                    <img src="<?php echo $sticky_logo; ?>" alt="<?php bloginfo( 'name' ); ?>" class="fusion-logo-1x fusion-sticky-logo-1x" />
                    <?php $retina_logo = Avada()->settings->get( 'sticky_header_logo_retina' ); ?>
                    <?php if ( $retina_logo ) : ?>
                        <?php $retina_logo = Avada_Sanitize::get_url_with_correct_scheme( $retina_logo ); ?>
                        <?php if ( Avada()->settings->get( 'sticky_retina_logo_width' ) && Avada()->settings->get( 'sticky_retina_logo_height' ) ) : ?>
                            <?php $logo_size['width']  = fusion_strip_unit( Avada()->settings->get( 'sticky_retina_logo_width' ) ); ?>
                            <?php $logo_size['height'] = fusion_strip_unit( Avada()->settings->get( 'sticky_retina_logo_height' ) ); ?>
                        <?php else : ?>
                            <?php $logo_size['width']  = ''; ?>
                            <?php $logo_size['height'] = ''; ?>
                        <?php endif; ?>
                        <?php $style = 'style="max-height: ' . $logo_size['height'] . 'px; height: auto;"'; ?>

                        <img src="<?php echo $retina_logo; ?>" alt="<?php bloginfo('name'); ?>" <?php echo $style; ?> class="fusion-logo-2x fusion-sticky-logo-2x" />
                    <?php else : ?>
                        <img src="<?php echo $sticky_logo; ?>" alt="<?php bloginfo( 'name' ); ?>" class="fusion-logo-2x fusion-sticky-logo-2x" />
                    <?php endif; ?>
                <?php endif; ?>
            </a>
        <?php endif; ?>
        <?php
        /**
         * avada_logo_append hook
         * @hooked avada_header_content_3 - 10
         */
        if ( Avada()->settings->get( 'header_position' ) == 'Top' ) : ?>
            <?php do_action( 'avada_logo_append' ); ?>
        <?php endif; ?>
    </div>
    <?php
}

?>

<div class="fusion-header-wrapper header-sidebar">
    <div class="header-sidebar-wrap">
        <div class="fusion-row">
            <div class="header-sidebar-col-left">

                <?php do_action( 'soict_header' ); ?>

                <!--<img src="<?php /*echo SoictApp::getImageUrl('HUST_logo.jpg') */?>" style="height: 150px" rel="nofollow" />
                <img src="<?php /*echo SoictApp::getImageUrl('logo.png') */?>" rel="nofollow" />-->
            </div>
            <div class="header-sidebar-col-right">
                <div class="site-name">
                    <h1>CỔNG THÔNG TIN THỰC TẬP DOANH NGHIỆP</h1>
                </div>

                <div class="soict-header-right">
                    <?php if(is_user_logged_in()): ?>
                        <?php dynamic_sidebar( 'header_bottom_sidebar' ); ?>
                    <?php endif; ?>
                </div>

                <?php if(!is_user_logged_in()): ?>
                    <div class="bbp-submit-wrapper">
                        <button type="submit" id="user-signin" class="button submit user-submit">Sign In</button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="header-bottom-sidebar">
                <?php if(!is_user_logged_in()): ?>
                    <?php dynamic_sidebar( 'header_bottom_sidebar' ); ?>
                <?php endif; ?>
            </div>

            <script type="text/javascript">
                $j = jQuery.noConflict();
                $j(document).ready(function(){
                    $j('#user-signin').toggle(function(){
                        $j('.header-bottom-sidebar .bbp-login-form').slideDown(300);
                    }, function(){
                        $j('.header-bottom-sidebar .bbp-login-form').slideUp(300);
                    });
                });
            </script>
        </div>
    </div>
</div>