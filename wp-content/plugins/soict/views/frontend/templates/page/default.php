<?php get_header(); ?>
    <div id="content" <?php Avada()->layout->add_style( 'content_style' ); ?>>
        <?php echo apply_filters( 'the_content', '' ) ?>
        <?php wp_reset_query(); ?>
    </div>
<?php do_action( 'fusion_after_content' ); ?>
<?php get_footer();

// Omit closing PHP tag to avoid "Headers already sent" issues.
