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
            <form class="header-search" method="get" action="<?php echo esc_url(home_url('/')); ?>" role="search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle cx="11" cy="11" r="6.25" stroke="currentColor" stroke-width="1.7"/>
                    <path d="M16 16.5 20.5 21" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                </svg>
                <label class="sr-only" for="hc-search">Search products</label>
                <input id="hc-search" type="search" name="s" placeholder="Search products" value="<?php echo esc_attr(get_search_query()); ?>" />
            </form>
            <div class="header-cta">
                <?php hc_btn(hc_quote_url(), 'Request a Quote'); ?>
            </div>
            <?php hc_header_icon_user(); ?>
            <?php hc_header_icon_cart(); ?>
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
                <a href="<?php echo esc_url(hc_account_url()); ?>"><?php echo is_user_logged_in() ? 'Account' : 'Sign in'; ?></a>
                <a href="<?php echo esc_url(hc_cart_url()); ?>">Cart<?php echo hc_cart_count() ? ' (' . esc_html((string) hc_cart_count()) . ')' : ''; ?></a>
            </div>
            <?php hc_btn(hc_quote_url(), 'Request a Quote'); ?>
        </nav>
    </div>
</header>
<main id="main">
