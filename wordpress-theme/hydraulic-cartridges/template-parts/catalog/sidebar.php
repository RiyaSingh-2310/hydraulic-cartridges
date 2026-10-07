<?php
$current_family = $args['family'] ?? null;
$current_group  = $args['group'] ?? null;
$tree           = hc_catalog_tree();
if (! $tree) {
    return;
}
?>
<aside class="catalog-sidebar" aria-label="Product navigation">
    <p class="eyebrow">Products</p>
    <a class="sidebar-all<?php echo is_post_type_archive('hc_product') ? ' is-active' : ''; ?>" href="<?php echo esc_url(hc_products_url()); ?>">Full catalog</a>
    <div class="sidebar-acc" data-acc-group>
        <?php foreach ($tree as $branch) : ?>
            <?php
            $parent    = $branch['term'];
            $is_family = $current_family && (int) $current_family->term_id === (int) $parent->term_id;
            $open      = $is_family || ($current_group && (int) $current_group->parent === (int) $parent->term_id);
            ?>
            <div class="sidebar-family<?php echo $is_family ? ' is-current' : ''; ?>">
                <button
                    type="button"
                    class="sidebar-toggle"
                    aria-expanded="<?php echo $open ? 'true' : 'false'; ?>"
                    data-acc-toggle
                >
                    <?php echo esc_html($parent->name); ?>
                </button>
                <div class="sidebar-panel" <?php echo $open ? '' : 'hidden'; ?> data-acc-panel>
                    <a class="<?php echo $is_family && ! $current_group ? 'is-active' : ''; ?>" href="<?php echo esc_url(hc_family_link($parent)); ?>">
                        All <?php echo esc_html($parent->name); ?>
                    </a>
                    <?php foreach ($branch['children'] as $child) : ?>
                        <?php $is_group = $current_group && (int) $current_group->term_id === (int) $child->term_id; ?>
                        <a class="<?php echo $is_group ? 'is-active' : ''; ?>" href="<?php echo esc_url(hc_family_link($child)); ?>">
                            <?php echo esc_html($child->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</aside>
