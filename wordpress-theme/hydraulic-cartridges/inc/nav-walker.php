<?php
/**
 * Navigation: desktop mega-menu for Products, mobile accordion.
 */

if (! defined('ABSPATH')) {
    exit;
}

function hc_is_products_nav_item($item) {
    if (is_array($item)) {
        $url = $item[1] ?? '';
    } else {
        $url = $item->url ?? '';
    }
    $products = untrailingslashit(hc_products_url());
    return untrailingslashit($url) === $products;
}

function hc_nav_item_active($url, $title = '') {
    if (untrailingslashit($url) === untrailingslashit(home_url('/'))) {
        return is_front_page();
    }
    if (hc_is_products_nav_item(array('', $url))) {
        return hc_is_products_context();
    }
    if (untrailingslashit($url) === untrailingslashit(hc_applications_url())) {
        return is_post_type_archive('hc_application') || is_singular('hc_application');
    }
    if (is_page()) {
        $page = get_post();
        return $page && untrailingslashit(get_permalink($page)) === untrailingslashit($url);
    }
    return false;
}

function hc_primary_nav($context = 'desktop') {
    $items = hc_nav_items();
    foreach ($items as $item) {
        $active = ! empty($item['active']);
        if ($context === 'desktop' && $item['products']) {
            hc_render_products_mega($item, $active);
            continue;
        }
        if ($context === 'mobile' && $item['products']) {
            hc_render_products_mobile($item, $active);
            continue;
        }
        printf(
            '<a href="%s"%s>%s</a>',
            esc_url($item['url']),
            $active ? ' class="active"' : '',
            esc_html($item['title'])
        );
    }
}

function hc_nav_items() {
    $built = array();
    if (has_nav_menu('primary')) {
        $locations = get_nav_menu_locations();
        $menu_id   = $locations['primary'] ?? 0;
        $entries   = $menu_id ? wp_get_nav_menu_items($menu_id) : array();
        foreach ($entries as $entry) {
            if ((int) $entry->menu_item_parent !== 0) {
                continue;
            }
            $url = $entry->url;
            $built[] = array(
                'title'    => $entry->title,
                'url'      => $url,
                'products' => hc_is_products_nav_item($entry),
                'active'   => hc_nav_item_active($url, $entry->title),
            );
        }
        if ($built) {
            return $built;
        }
    }
    return array(
        array('title' => 'Home', 'url' => home_url('/'), 'products' => false, 'active' => is_front_page()),
        array('title' => 'Products', 'url' => hc_products_url(), 'products' => true, 'active' => hc_is_products_context()),
        array('title' => 'Solutions', 'url' => hc_applications_url(), 'products' => false, 'active' => is_post_type_archive('hc_application') || is_singular('hc_application')),
        array('title' => 'About', 'url' => hc_page_url('about'), 'products' => false, 'active' => is_page('about')),
        array('title' => 'Resources', 'url' => hc_page_url('resources'), 'products' => false, 'active' => is_page('resources')),
        array('title' => 'Contact', 'url' => hc_page_url('contact'), 'products' => false, 'active' => is_page('contact')),
    );
}

function hc_render_products_mega($item, $active) {
    $ranges = hc_catalog_display_tree();
    ?>
    <div class="nav-item nav-item--products">
        <a href="<?php echo esc_url($item['url']); ?>" class="<?php echo $active ? 'active' : ''; ?>">
            <?php echo esc_html($item['title']); ?>
        </a>
        <?php if ($ranges) : ?>
            <div class="mega-panel" role="region" aria-label="Product families">
                <div class="mega-explorer">
                    <div class="mega-families">
                        <?php foreach ($ranges as $index => $range) : ?>
                            <a
                                class="mega-family<?php echo 0 === $index ? ' is-active' : ''; ?>"
                                href="<?php echo esc_url($range['url']); ?>"
                                data-mega-family="<?php echo esc_attr($range['slug']); ?>"
                            >
                                <?php echo esc_html($range['name']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <div class="mega-detail">
                        <?php foreach ($ranges as $index => $range) : ?>
                            <div
                                class="mega-detail-panel<?php echo 0 === $index ? ' is-active' : ''; ?>"
                                data-mega-panel="<?php echo esc_attr($range['slug']); ?>"
                                <?php echo 0 === $index ? '' : 'hidden'; ?>
                            >
                                <a class="mega-detail-title" href="<?php echo esc_url($range['url']); ?>">
                                    <?php echo esc_html($range['name']); ?>
                                </a>
                                <?php if (! empty($range['intro'])) : ?>
                                    <p class="mega-detail-copy"><?php echo esc_html($range['intro']); ?></p>
                                <?php endif; ?>
                                <ul class="mega-subs">
                                    <?php foreach ($range['children'] as $child) : ?>
                                        <li>
                                            <a href="<?php echo esc_url($child['url']); ?>">
                                                <?php echo esc_html($child['name']); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <a class="mega-foot" href="<?php echo esc_url($range['url']); ?>">
                                    Explore all <?php echo esc_html($range['name']); ?> →
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

function hc_render_products_mobile($item, $active) {
    $ranges = hc_catalog_display_tree();
    ?>
    <div class="mobile-products">
        <a href="<?php echo esc_url($item['url']); ?>" class="<?php echo $active ? 'active' : ''; ?>">
            <?php echo esc_html($item['title']); ?>
        </a>
        <?php if ($ranges) : ?>
            <div class="mobile-families" data-acc-group>
                <?php foreach ($ranges as $index => $range) : ?>
                    <div class="mobile-family">
                        <button type="button" class="mobile-family-toggle" aria-expanded="<?php echo 0 === $index ? 'true' : 'false'; ?>" data-acc-toggle>
                            <?php echo esc_html($range['name']); ?>
                        </button>
                        <div class="mobile-family-panel" <?php echo 0 === $index ? '' : 'hidden'; ?> data-acc-panel>
                            <a href="<?php echo esc_url($range['url']); ?>">All <?php echo esc_html($range['name']); ?></a>
                            <?php foreach ($range['children'] as $child) : ?>
                                <a href="<?php echo esc_url($child['url']); ?>"><?php echo esc_html($child['name']); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
