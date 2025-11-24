<?php
$data = wp_parse_args($args, [
    'id'            => '',
    'class'         => '',
    'item'          => null
]);

$user = $data['item'];

if ($user === null) {
    return;
}

$userID = $user->ID;

$avatar_id = get_user_meta($userID, 'ihc_avatar', true);
$avatar_url = wp_get_attachment_url($avatar_id);

$socials = get_field('socials', 'user_' . $userID);

$badge = get_field('badge', 'user_' . $userID);

$position = get_field('position', 'user_' . $userID);

$university = get_field('university', 'user_' . $userID);

$_class = 'member-grid-slider-item';
$_class .= !empty($data['class']) ? esc_attr(' ' . $data['class']) : '';

?>
<div class="<?php echo esc_attr($_class); ?>">
    <a href="<?php echo '/public-individual-page/' . $user->user_login . '/'; ?>">
        <div class="member-grid-slider-item__wrapper">
            <div class="member-grid-slider-item__avatar">
                <?php if (!empty($avatar_url)) : ?>
                    <img src="<?php echo esc_url($avatar_url); ?>" alt="User Avatar">
                <?php else : ?>
                    <img src="<?php echo esc_url(get_avatar_url($userID)); ?>" alt="Default Avatar">
                <?php endif; ?>
            </div>
            <div class="member-grid-slider-item__content">
                <?php if (!empty($badge) && strtolower($badge['value']) !== 'none'): ?>
                    <div class="member-grid-slider-item__badge text-center">
                        <?php echo twmp_get_svg_icon($badge['value']); ?>
                    </div>
                <?php endif; ?>
                <div class="member-grid-slider-item__content-wrapper">
                    <h3 class="member-grid-slider-item__fullname"><?php echo esc_html($user->display_name); ?></h3>
                    <?php if (!empty($position)): ?>
                        <span class="member-grid-slider-item__position text-center w-100 d-block"><?php echo esc_html($position); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($university)): ?>
                        <span class="member-grid-slider-item__university text-center w-100 d-block"><?php echo esc_html($university); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($socials)): ?>
                        <ul class="member-grid-slider-item__socials">
                            <?php
                            foreach ($socials as $item) {
                            ?>
                                <li>
                                    <a href="<?php echo esc_url($item['url']); ?>">
                                        <?php echo twmp_get_svg_icon(esc_attr($item['platform'])); ?>
                                    </a>
                                </li>
                            <?php }
                            ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </a>
</div>