<?php
$data = wp_parse_args($args, [
    'class' => 'member-grid-slider',
]);

$_class = !empty($data['class']) ? esc_attr(' ' . $data['class']) : '';

$_swiper_items = [];

$users = new \Indeed\Ihc\Db\SearchUsers();
$results = $users->getResults();

foreach ($results as $user) {
    ob_start();

    get_template_part(
        'templates/member-grid-slider-item',
        null,
        array(
            'item' => $user
        )
    );

    $content_html = ob_get_clean();

    $_swiper_items[] = [
        'class' => 'd-flex flex-column post-slider__slide',
        'content' => $content_html
    ];
}

wp_reset_postdata();

?>

<div data-block="member-grid-slider" class="<?php echo esc_attr($_class); ?>">
    <div class="member-grid-slider-swiper-container">
        <div class="member-grid-slider-swiper">
            <?php get_template_part('templates/swiper', null, [
                'items' => $_swiper_items,
                'lazyload' => false,
                'settings' => [
                    'autoplay' => 10000,
                    'pagination' => true,
                    'prevNextButtons' => false,
                    'prevSvgButton' => 'arrow-left',
                    'nextSvgButton' => 'arrow-right'
                ]
            ]); ?>
        </div>
    </div>
</div>