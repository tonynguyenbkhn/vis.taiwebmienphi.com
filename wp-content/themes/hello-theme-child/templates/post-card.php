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

$_class  = 'post-card';
$_class .= ! empty($data['class']) ? esc_attr(' ' . $data['class']) : '';

$post_data = $data['post_data'] ?? get_post($data['post_id']);

$post_title       = ! empty($data['post_title_limit']) ? wp_trim_words($post_data->post_title, $data['post_title_limit'], '...') : $post_data->post_title;
$post_description = $post_data->post_excerpt ? wp_trim_words($post_data->post_excerpt, $data['post_excerpt_limit'], '...') : wp_trim_words($post_data->post_content, $data['post_excerpt_limit'], '...');

$options = $data['options'];

?>
<article class="<?php echo esc_attr($_class); ?>">
	<div class="post-card__wrapper">
		<a class="image__overlay-link post-card__overlay-link" href="<?php echo esc_url_raw(get_permalink($post_data)); ?>" title="">
			<?php
			if (has_post_thumbnail($data['post_id']) && get_the_post_thumbnail_url($data['post_id'])) {
				get_template_part('templates/image', null, [
					'image_id' => get_post_thumbnail_id($post_data),
					'image_size' => 'full',
					'lazyload' => false,
					'class' => 'pe-none image--cover post-card__image',
				]);
			} else {
			?>
				<figure class="pe-none image--cover post-card__image">
					<?php echo wp_get_attachment_image(2456, 'full', null, [
						'class' => 'image__img'
					]); ?>
				</figure>
			<?php
			}
			?>
		</a>
		<div class="post-card__content">
			<a class="post-card__title-link" href="<?php echo esc_url_raw(get_permalink($post_data)); ?>" title="">
				<h3 class="post-card__title h5"><?php echo esc_html($post_title); ?></h3>
			</a>
			<?php if ($options['show_excerpt']): ?>
				<p class="post-card__description"><?php echo esc_html($post_description); ?> </p>
			<?php endif; ?>
			<?php
			get_template_part('templates/post-meta', null, [
				'date' => $options['show_date'],
				'author' => $options['show_author'],
				'categories' => $options['show_categories'],
				'class' => 'post-card__post-meta'
			]);
			?>
			<?php if ($data['view_more_button'] !== '') : ?>
				<div class="post-card__footer">
					<?php
					get_template_part('templates/button', null, [
						'class'       => 'post-card__button',
						'button_text' => $data['view_more_button'],
						'button_url' => esc_url_raw(get_permalink($post_data)),
						'svg_icon_after' => twmp_get_svg_icon('angle-long-right')
					]);
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</article>