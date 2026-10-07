<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header <?php echo is_front_page() ? 'overlay' : 'solid'; ?><?php echo hc_show_catalog_bar() ? ' has-catalog-bar' : ''; ?>">
    <div class="container-wide header-inner">
        <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="Hydraulic Cartridges home">
            <?php hc_logo_markup(); ?>
        </a>
        <nav class="desktop-nav" aria-label="Primary">
            <?php hc_primary_nav('desktop'); ?>
        </nav>
        <div class="header-tools">
            <?php hc_header_icon_wishlist(); ?>
            <?php hc_header_icon_cart(); ?>
            <?php hc_header_icon_user(); ?>
        </div>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu">
            <span></span>
            <span class="sr-only">Open menu</span>
        </button>
    </div>
    <?php
    if (hc_show_catalog_bar()) {
        hc_render_catalog_bar();
    }
    ?>
    <div class="menu-layer">
        <button type="button" class="menu-backdrop" aria-label="Close menu"></button>
        <nav id="mobile-menu" class="mobile-nav" aria-label="Mobile">
            <div class="mobile-nav-head">
                <p class="eyebrow">Menu</p>
                <button type="button" class="menu-close">Close</button>
            </div>
            <div class="mobile-nav-links">
                <?php hc_primary_nav('mobile'); ?>
            </div>
            <?php hc_btn(hc_quote_url(), 'Request a Quote'); ?>
        </nav>
    </div>
</header>
<main id="main">
