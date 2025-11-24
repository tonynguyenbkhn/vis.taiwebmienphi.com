<?php

$data = wp_parse_args(
	$args,
	array(
		'class'              => '',
		'post_id '           => '',
		'post_data'          => '',
		'post_title_limit'   => 25,
		'post_excerpt_limit' => 20,
		'view_more_button'   => __('View more', 'twmp-vis'),
		'options' => [
			'show_excerpt' => true,
			'show_date' => true,
			'show_author' => true,
			'show_categories' => true
		]
	)
);

$_class  = 'post-row col-lg-12 col-md-6 col-12';
$_class .= ! empty($data['class']) ? esc_attr(' ' . $data['class']) : '';

$post_data = $data['post_data'] ?? get_post($data['post_id']);

$post_title       = ! empty($data['post_title_limit']) ? wp_trim_words($post_data->post_title, $data['post_title_limit'], '...') : $post_data->post_title;
$post_description = $post_data->post_excerpt ? wp_trim_words($post_data->post_excerpt, $data['post_excerpt_limit'], '...') : wp_trim_words($post_data->post_content, $data['post_excerpt_limit'], '...');

$options = $data['options'];

?>
<article class="<?php echo esc_attr($_class); ?>">
	<div class="post-row__wrapper row">
		<div class="col-lg-3">
			<a class="image__overlay-link post-row__overlay-link" href="<?php echo esc_url_raw(get_permalink($post_data)); ?>" title="">
				<?php
				get_template_part('templates/image', null, [
					'image_id' => get_post_thumbnail_id($post_data),
					'image_size' => 'full',
					'lazyload' => false,
					'class' => 'pe-none image--cover post-row__image',
				]);
				?>
			</a>
		</div>
		<div class="col-lg-9">
			<div class="post-row__content">
				<div class="d-flex align-items-center">
					<div class="restricted">
						<?php echo twmp_get_svg_icon('restricted') ?>
						<span>premium access</span>
					</div>
					<div class="post-type">
						<span>Video</span>
					</div>
				</div>
				<a class="post-row__title-link" href="<?php echo esc_url_raw(get_permalink($post_data)); ?>" title="">
					<h3 class="post-row__title h5"><?php echo esc_html($post_title); ?></h3>
				</a>
				<div class="post-row__author">
					<span>By: <?php echo get_the_author_meta('user_nicename'); ?></span>
				</div>
				<div class="post-row__tags">
					<span>Tags: Education, Quality, Format</span>
				</div>
			</div>
		</div>
	</div>
</article>