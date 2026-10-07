<?php
$current = $args['current'] ?? null;
$tree    = hc_catalog_tree();
if (! $tree) {
    return;
}
?>
<nav class="related-ranges" aria-label="Related product families">
    <p class="eyebrow">Other product families</p>
    <div class="related-range-links">
        <?php foreach ($tree as $branch) : ?>
            <?php
            $term = $branch['term'];
            if ($current && (int) $current->term_id === (int) $term->term_id) {
                continue;
            }
            ?>
            <a href="<?php echo esc_url(hc_family_link($term)); ?>"><?php echo esc_html(hc_public_label($term->name, $term->slug)); ?></a>
        <?php endforeach; ?>
    </div>
</nav>
