<?php

$data = wp_parse_args($args, [
    'title_class' => '',
    'description_class' => '',
    'class' => '',
    'title' => '',
    'description' => '',
]);

$_class = 'heading';
$_class .= !empty($data['class']) ? esc_attr(' ' . $data['class']) : '';

$_title_class = 'heading__title';
$_title_class .= !empty($data['title_class']) ? esc_attr(' ' . $data['title_class']) : '';

$_description_class = 'heading__description';
$_description_class .= !empty($data['description_class']) ? esc_attr(' ' . $data['description_class']) : '';

?>

<?php if (!empty($data['title'])) : ?>
    <div class="<?php echo esc_attr($_class) ?>">
        <h2 class="<?php echo esc_attr($_title_class); ?>"><?php echo $data['title']; ?></h2>
        <?php if (!empty($data['description'])) : ?>
            <div class="<?php echo esc_attr($_description_class); ?>">
                <?php echo $data['description'] ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>