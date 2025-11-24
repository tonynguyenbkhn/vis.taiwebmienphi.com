<?php wp_enqueue_script( 'ihc-social_utilities', IHC_URL . 'assets/js/social.js', ['jquery'], '13.5' );?>
<?php if ( isset( $data['users_sm'] ) ):?>
  <?php echo ihc_print_social_media_icons( 'update', $data['users_sm'] );?>
<?php endif;?>
