<?php
$ranges = hc_catalog_display_tree();
if (! $ranges) {
    return;
}
?>
<section class="section home-catalog" id="product-range" aria-labelledby="product-range-title">
    <div class="container">
        <?php
        hc_section_header(
            'Shop by category',
            'The manufacturing range',
            'Six product families for industrial fluid power. Open a category for the full group list, or use the category bar above to jump into a family.',
            true
        );
        ?>
        <div class="overview-grid">
            <?php foreach ($ranges as $index => $range) : ?>
                <?php
                $preview = array_slice($range['children'], 0, 3);
                $more    = max(0, count($range['children']) - 3);
                ?>
                <?php hc_reveal_open(min($index * 0.04, 0.16)); ?>
                <article class="overview-card">
                    <a class="overview-visual" href="<?php echo esc_url($range['url']); ?>" aria-hidden="true" tabindex="-1">
                        <?php hc_product_visual($range['visual'], $range['name']); ?>
                    </a>
                    <div class="overview-body">
                        <p class="eyebrow"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?> · <?php echo esc_html(count($range['children'])); ?> groups</p>
                        <h3><?php echo esc_html($range['name']); ?></h3>
                        <?php if (! empty($range['intro'])) : ?>
                            <p><?php echo esc_html($range['intro']); ?></p>
                        <?php endif; ?>
                        <?php if ($preview) : ?>
                            <ul class="overview-preview">
                                <?php foreach ($preview as $group) : ?>
                                    <li>
                                        <a href="<?php echo esc_url($group['url']); ?>"><?php echo esc_html($group['name']); ?></a>
                                    </li>
                                <?php endforeach; ?>
                                <?php if ($more) : ?>
                                    <li class="overview-more">+ <?php echo esc_html((string) $more); ?> more groups</li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>
                        <a class="explore-link" href="<?php echo esc_url($range['url']); ?>">Explore all <?php echo esc_html($range['name']); ?> →</a>
                    </div>
                </article>
                <?php hc_reveal_close(); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
