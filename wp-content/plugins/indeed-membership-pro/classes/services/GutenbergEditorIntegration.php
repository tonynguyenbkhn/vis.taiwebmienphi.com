<?php
namespace Indeed\Ihc\Services;

class GutenbergEditorIntegration
{
    public function __construct()
    {
        // locker shortcode block. Since version 13.4.
        add_action( 'init', array( $this, 'register_locker_block' ) );

        // ump shortcodes.
        if ( !is_admin() ){
            return;
        }
        if ( !function_exists( 'register_block_type' ) ) {
            return;
        }
        add_filter( 'block_categories_all', array( $this, 'registerCategory'), 10, 2 ); //
        add_action( 'in_admin_footer', array($this, 'assets') );

    }

    public function registerCategory( $categories=[], $post=null )
    {
        $categories[] = array(
                              'slug' => 'ihc-shortcodes',
                              'title' => esc_html__( 'Ultimate Membership Pro - Shortcodes', 'ihc' ),
                              'icon'  => '',
        );
        return $categories;
    }

    public function assets()
    {
        global $current_screen, $wp_version;
        if (!isset($current_screen)) {
            $current_screen = get_current_screen();
        }
        if ( !method_exists($current_screen, 'is_block_editor') || !$current_screen->is_block_editor() ) {
            return;
        }
        wp_enqueue_script( 'ihc-gutenberg-locker-integration' );
    }

    /**
     * Register the locker block.
     * Since version 13.4.
     *
     * @param void
     *
     * @return void
     */
    public function register_locker_block()
    {
      global $wp_version;
      if ( ! function_exists( 'register_block_type' ) ) {
          return;
      }

      wp_register_script(
          'iump-locker',
          IHC_URL . 'assets/js/gutenberg_locker_integration.js',
          array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ),
          '13.5'
      );

      if ( version_compare ( $wp_version , '5.7', '>=' ) ){
          wp_localize_script( 'iump-locker', 'iump_locker_options', $this->lockerOptions( false ) );
      } else {
          wp_localize_script( 'iump-locker', 'iump_locker_options', $this->lockerOptions() );
      }

      register_block_type( 'iump/locker', array(
          'editor_script'   => 'iump-locker',
          'render_callback' => array( $this, 'locker_render'),
      ) );
    }

    /**
     * Return the output of locker.
     * Since version 13.4.
     *
     * @param bool $attributes Locker params.
     * @param string $content Content inside shortcode tags.
     *
     * @return string Output.
     */
    public function locker_render( $attributes=array(), $content='' )
    {
        if ( !function_exists( 'ihc_hide_content_shortcode' ) ) {
            require_once IHC_PATH . 'public/shortcodes.php';
        }
        $meta['ihc_mb_type'] = isset( $attributes['lockerType'] ) ? sanitize_text_field( $attributes['lockerType']) : '';
        $meta['ihc_mb_template'] = isset( $attributes['template'] ) ? sanitize_text_field( $attributes['template']) : '';
        $meta['ihc_mb_who'] = isset( $attributes['lockerTarget'] ) ? implode( ',', indeed_sanitize_array( $attributes['lockerTarget'] ) ) : '';
        return ihc_hide_content_shortcode( $meta, $content );
    }

    /**
     * Return locker possible option values.
     *
     * @param bool $asJson Return the values as json or simple array.
     *
     * @return mixed Return string or array
     */
    public function lockerOptions( $asJson=true )
    {
        $targetValues = array(
              array(
                'value'     => 'all',
                'label'     => esc_html__( 'All', 'ihc' ),
              ),
              array(
                'value'     => 'reg',
                'label'     => esc_html__( 'Registered Users', 'ihc' ),
              ),
              array(
                'value'     => 'unreg',
                'label'     => esc_html__( 'Unregistered Users', 'ihc' ),
              ),
        );
        $levels = \Indeed\Ihc\Db\Memberships::getAll();
        if ( $levels ){
            foreach ( $levels as $id => $level ){
                $targetValues[] = array(
                        'value'       => $id,
                        'label'       => $level['name'],
                );
            }
        }
        $templates = array();
        $lockers = ihc_return_meta('ihc_lockers');
        if ( $lockers ){
            $templates[] = array(
                    'value'       => '',
                    'label'       => '...',
            );
            foreach ( $lockers as $k => $v ){
                $templates[] = array(
                        'value'       => $k,
                        'label'       => $v['ihc_locker_name'],
                );
            }
        }
        $data = [
            'templates'         => $templates,
            'lockerTarget'      => $targetValues,
            'lockerType'        => array(
                                array(
                                    'value'     => 'show',
                                    'label'     => esc_html__( 'Show', 'ihc' ),
                                ),
                                array(
                                    'value'     => 'block',
                                    'label'     => esc_html__( 'Block', 'ihc' )
                                ),
            ),
            'inside_content'    => ''
        ];
        if ( $asJson ){
            return json_encode( $data );
        }
        return $data;
    }

}
