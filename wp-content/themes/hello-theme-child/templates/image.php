<?php
$data = wp_parse_args($args, [
    'class' => '',
    'image_id' => '',
    'image_size' => '',
    'image_class' => '',
    'lazyload' => true,
    'alt' => '',
    'sizes' => '',
    'srcset' => ''
]);

$_class = 'image';
$_class .= !empty( $data['class'] ) ? esc_attr(' ' . $data['class']) : '';

$attr['alt'] = get_bloginfo('name');
if ( $data['alt'] ) {
    $attr['alt'] = $data['alt'];
}
if ( $data['sizes'] ) {
    $attr['sizes'] = $data['sizes'];
}
if ( $data['srcset'] ) {
    $attr['srcset'] = $data['srcset'];
}
if ( !empty( $data['image_id'] ) ) :
    $_image_class = 'image__img';
    $_image_class .= !empty( $data['image_class'] ) ? esc_attr(' ' . $data['image_class']) : '';
    $attr['class'] = $_image_class;
    if ( ! $data['lazyload'] ) {
        $_image_class .= ' no-lazy';
    }
?>
    <figure class="<?php echo esc_attr( $_class ); ?>">
        <?php echo wp_get_attachment_image( $data['image_id'], $data['image_size'], false, $attr); ?>
    </figure>
<?php endif;

