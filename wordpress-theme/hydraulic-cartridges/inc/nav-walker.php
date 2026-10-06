<?php
/**
 * Nav walker that emits React-equivalent <a> markup (no extra wrappers).
 */

if (! defined('ABSPATH')) {
    exit;
}

class HC_Nav_Walker extends Walker_Nav_Menu {
    public function start_lvl(&$output, $depth = 0, $args = null) {
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = is_array($item->classes) ? $item->classes : array();
        $active  = in_array('current-menu-item', $classes, true)
            || in_array('current-menu-ancestor', $classes, true)
            || in_array('current-menu-parent', $classes, true)
            || in_array('current_page_item', $classes, true)
            || in_array('current_page_parent', $classes, true);

        if (untrailingslashit($item->url) === untrailingslashit(home_url('/')) && is_front_page()) {
            $active = true;
        }

        $class_attr = $active ? ' class="active"' : '';
        $output    .= '<a href="' . esc_url($item->url) . '"' . $class_attr . '>' . esc_html($item->title) . '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
    }
}

function hc_primary_nav() {
    if (has_nav_menu('primary')) {
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'fallback_cb'    => 'hc_fallback_nav',
            'walker'         => new HC_Nav_Walker(),
            'depth'          => 1,
        ));
        return;
    }
    hc_fallback_nav();
}

function hc_fallback_nav() {
    $items = array(
        array('Home', home_url('/'), is_front_page()),
        array('Products', hc_products_url(), is_post_type_archive('hc_product') || is_singular('hc_product')),
        array('Solutions', hc_applications_url(), is_post_type_archive('hc_application') || is_singular('hc_application')),
        array('About', hc_page_url('about'), is_page('about')),
        array('Resources', hc_page_url('resources'), is_page('resources')),
        array('Contact', hc_page_url('contact'), is_page('contact')),
    );
    foreach ($items as $item) {
        printf(
            '<a href="%s"%s>%s</a>',
            esc_url($item[1]),
            $item[2] ? ' class="active"' : '',
            esc_html($item[0])
        );
    }
}
