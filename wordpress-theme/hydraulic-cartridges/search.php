<?php
/**
 * Product search results.
 */

get_header();
$q = get_search_query();
hc_page_hero(
    'Search',
    $q ? 'Results for “' . $q . '”' : 'Search the catalog',
    'Find series by name, model, or family.'
);
?>
<section class="section">
    <div class="container">
        <form class="header-search" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="display: block; margin-bottom: 1.75rem; max-width: 28rem;">
            <input type="search" name="s" value="<?php echo esc_attr($q); ?>" placeholder="Search products" />
        </form>
        <?php if (have_posts()) : ?>
            <div class="product-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    hc_listing_card(hc_product_from_post(get_post()));
                endwhile;
                ?>
            </div>
        <?php else : ?>
            <p class="notice">No catalog series matched that search. Try a model number, family, or cavity keyword.</p>
            <?php hc_btn(hc_products_url(), 'Browse products'); ?>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
