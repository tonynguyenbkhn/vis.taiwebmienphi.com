<?php

/**
 * Template Name: Page Search
 * Template Post Type: page
 */
get_header();
?>
<?php echo do_shortcode('[elementor-template id="696"]'); ?>
<div class="page page-standard">
	<div class="page-standard__container">
		<div class="row page-standard__row">
			<div class="page-standard__col page-standard__left col-lg-12 col-md-12 col-12">

				<main id="primary" class="site-main">

					<?php
					// --- BẮT ĐẦU LOGIC FILTER ---

					$search_keyword = isset($_GET['search_key']) ? sanitize_text_field($_GET['search_key']) : '';
					$search_title   = isset($_GET['search_title']) ? sanitize_text_field($_GET['search_title']) : '';
					$search_author  = isset($_GET['search_author']) ? sanitize_text_field($_GET['search_author']) : '';
					$from_year      = isset($_GET['from_year']) ? sanitize_text_field($_GET['from_year']) : '';
					$to_year        = isset($_GET['to_year']) ? sanitize_text_field($_GET['to_year']) : '';

					$filter_args = array();

					// --- 1. Tìm theo tiêu đề hoặc nội dung ---
					if (!empty($search_title)) {
						$filter_args['s'] = $search_title;
					} elseif (!empty($search_keyword)) {
						$filter_args['s'] = $search_keyword;
					}

					// --- 2. Tìm theo tác giả ---
					// Nếu người dùng nhập tên tác giả trong search_key, ta sẽ kiểm tra user_login và display_name
					// if (!empty($search_keyword)) {
					// 	$user = get_user_by('login', $search_keyword);
					// 	if (!$user) {
					// 		$user = get_user_by('slug', sanitize_title($search_keyword));
					// 	}
					// 	if (!$user) {
					// 		$user_query = new WP_User_Query([
					// 			'search' => '*' . esc_attr($search_keyword) . '*',
					// 			'search_columns' => ['display_name', 'user_nicename'],
					// 			'number' => 1
					// 		]);
					// 		if (!empty($user_query->results)) {
					// 			$user = $user_query->results[0];
					// 		}
					// 	}
					// 	if ($user) {
					// 		$filter_args['author'] = $user->ID;
					// 		unset($filter_args['s']);
					// 	}
					// }

					// --- 3. Tìm theo author query var riêng ---
					if (!empty($search_author)) {
						$author_obj = get_user_by('login', sanitize_text_field($search_author));
						if ($author_obj) {
							$filter_args['author'] = $author_obj->ID;
						}
					}

					// --- 4. Lọc theo năm (từ năm - đến năm) ---
					$date_query_args = array('inclusive' => true);
					if (!empty($from_year) && is_numeric($from_year)) {
						$date_query_args['after'] = array(
							'year' => (int) $from_year,
							'month' => 1,
							'day' => 1,
						);
					}
					if (!empty($to_year) && is_numeric($to_year)) {
						$date_query_args['before'] = array(
							'year' => (int) $to_year,
							'month' => 12,
							'day' => 31,
						);
					}
					if (count($date_query_args) > 1) {
						$filter_args['date_query'] = array($date_query_args);
					}
					?>

					<div class="page-search">
						<div class="container">
							<form method="get" class="search-form" action="<?php echo esc_url(get_permalink()); ?>">
								<label>
									<span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'twmp-vis') ?></span>
									<input
										type="search"
										class="search-field"
										placeholder="<?php echo _x('Search by keyword, author, or event…', 'placeholder', 'twmp-vis'); ?>"
										value="<?php echo esc_attr($filter_args['s']); ?>"
										name="search_key"
										title="<?php echo _x('Search for:', 'label', 'twmp-vis'); ?>">
								</label>
								<?php
								printf(
									'<button class="search-submit" aria-label="%1$s">%2$s</button>',
									esc_attr(_x('Search', 'submit button', 'twmp-vis')),
									twmp_get_svg_icon('search-icon') // phpcs:ignore -- Escaping not necessary here.
								);
								?>
								<?php
								printf(
									'<button data-open-modal="modal-filter-form" class="filter-submit">%1$s</button>',
									twmp_get_svg_icon('filter') // phpcs:ignore -- Escaping not necessary here.
								);
								?>
							</form>

							<!-- Sort List -->
							<div class="sort-list">
								<div class="d-flex">
									<span>Sorted by:</span>
									<ul class="reset d-flex">
										<li>
											<a href="<?php echo esc_url(get_permalink('/')); ?>">All</a>
										</li>
										<li>
											<a href="">News</a>
										</li>
										<li>
											<a href="">Events</a>
										</li>
										<li>
											<a href="">Updates</a>
										</li>
										<li>
											<a href="">Publications</a>
										</li>
									</ul>
								</div>
							</div>

							<?php
							$post_args           = array(
								'post_type'              => 'post',
								'post_status'            => 'publish',
								'update_post_meta_cache' => false,
								'update_post_term_cache' => false,
								'no_found_rows'          => true,
								'posts_per_page'          => 4,
							);

							// HỢP NHẤT VỚI ARGS TÌM KIẾM
							$post_args = array_merge($post_args, $filter_args);

							$post_query = new WP_Query($post_args);

							?>

							<?php if ($post_query->have_posts()) : ?>
								<!-- Lastest news -->
								<div class="d-flex justify-content-between page-search-common page-search-lastest-news__wrapper">
									<?php
									get_template_part('templates/heading', null, [
										'title_class' => 'page-search-lastest-news__title',
										'description_class' => 'page-search-lastest-news__description',
										'class' => 'page-search-lastest-news__header',
										'title' => esc_html('Lastest news', 'twmp-vis')
									]);
									?>
									<?php
									get_template_part('templates/button', null, [
										'class'       => 'page-search-lastest-news__button page-search__button',
										'button_text' => esc_html('See more', 'twmp-vis'),
										'button_url' => esc_url(''),
									]);
									?>
								</div>
								<div class="row">
									<?php
									$count = 0;
									while ($post_query->have_posts()) :
										$post_query->the_post();
										$count++;

										// Bài viết đầu tiên -> layout lớn bên trái
										if ($count === 1) : ?>
											<div class="col-lg-7">
												<div class="featured-post position-relative rounded overflow-hidden">
													<a href="<?php the_permalink(); ?>">
														<?php if (has_post_thumbnail()) : ?>
															<?php the_post_thumbnail('large', ['class' => 'img-fluid w-100']); ?>
														<?php endif; ?>
														<div class="overlay position-absolute bottom-0 start-0 w-100">
															<h5 class="text-white mb-0 text-uppercase fw-bold">
																<?php the_title(); ?>
															</h5>
														</div>
													</a>
												</div>
											</div>

											<div class="col-lg-5">
												<div class="side-posts d-flex flex-column">
												<?php else : ?>
													<div class="side-post">
														<div class="row">
															<div class="col-lg-4">
																<div class="post-thumb">
																	<a href="<?php the_permalink(); ?>">
																		<?php if (has_post_thumbnail()) : ?>
																			<?php the_post_thumbnail('thumbnail', ['class' => 'rounded w-100']); ?>
																		<?php endif; ?>
																	</a>
																</div>
															</div>

															<div class="col-lg-8">
																<div class="post-info">
																	<small class="text-muted d-block mb-1">
																		<?php echo twmp_get_svg_icon('calendar-1'); ?>
																		<span><?php echo get_the_date('d/m/Y'); ?></span>
																	</small>
																	<a href="<?php the_permalink(); ?>" class="text-dark fw-semibold text-decoration-none">
																		<?php the_title(); ?>
																	</a>
																</div>
															</div>
														</div>
													</div>
												<?php endif; ?>
											<?php endwhile; ?>
												</div> <!-- end .side-posts -->
											</div> <!-- end .col-lg-6 -->
								</div> <!-- end .row -->
							<?php endif; ?>
							<?php wp_reset_postdata(); ?>

							<?php
							$event_args = array(
								'post_type'              => 'event',
								'post_status'            => 'publish',
								'update_post_meta_cache' => false,
								'update_post_term_cache' => false,
								'no_found_rows'          => true,
								'posts_per_page'         => 3
							);

							// HỢP NHẤT VỚI ARGS TÌM KIẾM
							$event_args = array_merge($event_args, $filter_args);

							$event_query = new WP_Query($event_args);

							?>
							<?php if ($event_query->have_posts()) : ?>
								<!-- Events -->
								<div class="d-flex justify-content-between page-search-common page-search-event__wrapper">
									<?php
									get_template_part('templates/heading', null, [
										'title_class' => 'page-search-lastest-news__title',
										'description_class' => 'page-search-lastest-news__description',
										'class' => 'page-search-lastest-news__header',
										'title' => esc_html('Event', 'twmp-vis')
									]);
									?>
									<?php
									get_template_part('templates/button', null, [
										'class'       => 'page-search-lastest-news__button page-search__button',
										'button_text' => esc_html('See more', 'twmp-vis'),
										'button_url' => esc_url(''),
									]);
									?>
								</div>

								<?php get_template_part('templates/post-grid', null, [
									'class' => 'post-grid',
									'block_layout' => '3-col',
									'query' => $event_query
								]);
								?>
							<?php endif; ?>

							<?php
							// Tên biến $event_query đã được sử dụng, đổi tên biến args
							$monthly_args = array(
								'post_type'              => 'event',
								'post_status'            => 'publish',
								'update_post_meta_cache' => false,
								'update_post_term_cache' => false,
								'no_found_rows'          => true,
								'posts_per_page'         => 4
							);

							// HỢP NHẤT VỚI ARGS TÌM KIẾM
							$monthly_args = array_merge($monthly_args, $filter_args);

							$monthly_query = new WP_Query($monthly_args); // Đổi tên biến query
							?>

							<?php if ($event_query->have_posts()) : ?>
								<!-- Monthly Updates -->
								<div class="d-flex justify-content-between page-search-common page-search-monthly-update__wrapper">
									<?php
									get_template_part('templates/heading', null, [
										'title_class' => 'page-search-lastest-news__title',
										'description_class' => 'page-search-lastest-news__description',
										'class' => 'page-search-lastest-news__header',
										'title' => esc_html('Monthly updates', 'twmp-vis')
									]);
									?>
									<?php
									get_template_part('templates/button', null, [
										'class'       => 'page-search-lastest-news__button page-search__button',
										'button_text' => esc_html('See more', 'twmp-vis'),
										'button_url' => esc_url(''),
									]);
									?>
								</div>

								<?php get_template_part('templates/post-grid', null, [
									'class' => 'post-grid',
									'block_layout' => '4-col',
									'query' => $monthly_query // Sử dụng biến query mới
								]);
								?>
							<?php endif; ?>

							<?php
							$publications_args = array(
								'post_type' => 'publication',
								'post_status' => 'publish',
								'update_post_meta_cache' => false,
								'update_post_term_cache' => false,
								'no_found_rows'          => true,
								'posts_per_page'         => 3
							);

							// HỢP NHẤT VỚI ARGS TÌM KIẾM
							$publications_args = array_merge($publications_args, $filter_args);

							$publications_query = new WP_Query($publications_args);
							?>

							<?php
							if ($publications_query->have_posts()) : ?>
								<!-- Publications -->
								<div class="d-flex justify-content-between page-search-common page-search-publications__wrapper">
									<?php
									get_template_part('templates/heading', null, [
										'title_class' => 'page-search-lastest-news__title',
										'description_class' => 'page-search-lastest-news__description',
										'class' => 'page-search-lastest-news__header',
										'title' => esc_html('Publications', 'twmp-vis')
									]);
									?>
									<?php
									get_template_part('templates/button', null, [
										'class'       => 'page-search-lastest-news__button page-search__button',
										'button_text' => esc_html('See more', 'twmp-vis'),
										'button_url' => esc_url(''),
									]);
									?>
								</div>
								<div class="publications-list">
									<?php while ($publications_query->have_posts()) : $publications_query->the_post(); ?>
										<div class="publication-item">
											<a href="<?php the_permalink(); ?>" class="publication-title">
												<?php the_title(); ?>
											</a>
											<div class="publication-meta">
												<?php echo get_the_excerpt(); ?>
											</div>
										</div>
									<?php endwhile; ?>
								</div>
								<?php wp_reset_postdata(); ?>
							<?php endif; ?>
						</div>
					</div>

				</main><!-- #main -->
			</div>
		</div>
	</div>
</div>
<?php
get_template_part('templates/modal-filter-form', null, [
	'id' => 'modal-filter',
	'class' => 'modal--filter-form',
	'attributes' => 'data-block="modal-filter-form"',
	'data_search' => [
		'title' => $search_title,
		'author' => $search_author,
		'from' => $from_year,
		'to' => $to_year,
	]
]);
get_footer();
