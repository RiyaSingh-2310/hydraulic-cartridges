<?php
/**
 * Products hub — major families.
 */

get_header();
hc_page_hero(
    'Catalog',
    'Hydraulic cartridge families',
    'Specify by family, then by cavity and function — valves, pumps, filters, accessories, heat exchangers, and specialties.',
    false,
    array(
        array('label' => 'Home', 'url' => home_url('/')),
        array('label' => 'Products', 'url' => ''),
    )
);
$tree = hc_catalog_tree();
?>
<section class="section">
    <div class="container catalog-shell">
        <?php get_template_part('template-parts/catalog/sidebar', null, array('family' => null, 'group' => null)); ?>
        <div class="catalog-main">
            <div class="family-grid">
                <?php foreach ($tree as $branch) : ?>
                    <?php hc_family_card($branch['term'], count($branch['children'])); ?>
                <?php endforeach; ?>
            </div>
            <?php get_template_part('template-parts/catalog/related-ranges'); ?>
        </div>
    </div>
</section>
<?php
get_footer();
