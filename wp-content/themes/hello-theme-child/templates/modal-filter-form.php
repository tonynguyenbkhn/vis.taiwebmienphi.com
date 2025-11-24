<?php

$data = wp_parse_args($args, [
    'class' => '',
    'id' => '',
    'attributes' => '',
    'close_button_class' => '',
    'data_search' => []
]);

$_class = 'modal';
$_class .= !empty($data['class']) ? esc_attr(' ' . $data['class']) : '';

$_attributes = sprintf('id="%s" role="dialog"', $data['id']);
$_attributes .= !empty($data['attributes']) ? ' ' . $data['attributes'] : '';

$_close_button_class = !empty($data['close_button_class']) ? $data['close_button_class'] : 'js-close-button';

?>

<div class="<?php echo $_class; ?>" <?php echo $_attributes; ?>>
    <div class="modal__wrapper">
        <div class="modal__header">
            <span class="modal__title"><?php esc_html_e('advanced searching', 'twmp-vis'); ?></span>
            <button class="modal__close-button" data-close-modal="modal-search-form" aria-label="<?php echo esc_attr__('Close a search form modal', 'twmp-vis'); ?>">
                <?php echo twmp_get_svg_icon('close'); ?>
            </button>
        </div>
        <div class="modal__content js-content">
            <form action="<?php echo esc_url(get_permalink()); ?>" method="get" class="custom-search-form">
                <div class="row">
                    <div class="col-12">
                        <div class="form-control">
                            <label for="title">Title</label>
                            <input type="text" name="search_title" id="title" value="<?php echo esc_attr($data['data_search']['title']); ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-control">
                            <label for="author">Author</label>
                            <input type="text" name="search_author" id="author" value="<?php echo esc_attr($data['data_search']['author']); ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-control">
                            <label for="from_year">From</label>
                            <input type="text" name="from_year" id="from_year" value="<?php echo esc_attr($data['data_search']['from_year']); ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-control">
                            <label for="to_year">To</label>
                            <input type="text" name="to_year" id="to_year" value="<?php echo esc_attr($data['data_search']['to_year']); ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <button class="modal__close-button <?php echo $_close_button_class; ?>" data-close-modal="modal-filter-form" aria-label="<?php _e('Close a modal', 'twmp-vis'); ?>">
            <?php echo twmp_get_svg_icon('close'); ?>
        </button>
    </div>
</div>