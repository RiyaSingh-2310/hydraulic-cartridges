<?php
/**
 * Hydraulic Cartridges theme bootstrap.
 */

if (! defined('ABSPATH')) {
    exit;
}

define('HC_VERSION', '1.0.0');

$hc_dir = get_template_directory();

require_once $hc_dir . '/inc/helpers.php';
require_once $hc_dir . '/inc/theme-setup.php';
require_once $hc_dir . '/inc/enqueue.php';
require_once $hc_dir . '/inc/post-types.php';
require_once $hc_dir . '/inc/nav-walker.php';
require_once $hc_dir . '/inc/customizer.php';
require_once $hc_dir . '/inc/meta-boxes.php';
require_once $hc_dir . '/inc/seed.php';
require_once $hc_dir . '/inc/visuals.php';
require_once $hc_dir . '/inc/catalog-data.php';
require_once $hc_dir . '/inc/catalog.php';
require_once $hc_dir . '/inc/seed-catalog.php';
require_once $hc_dir . '/inc/commerce.php';
