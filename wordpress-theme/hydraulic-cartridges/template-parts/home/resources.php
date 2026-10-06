<?php $resources = hc_get_resources(); ?>
<section class="section">
    <div class="container">
        <?php
        hc_section_header(
            'Resources',
            'Technical material, ready for the desk',
            'Catalog pages, specifications, and application notes. File delivery is a placeholder in this frontend phase.',
            true
        );
        ?>
        <div class="resource-grid">
            <?php foreach ($resources as $index => $item) : ?>
                <?php hc_reveal_open($index * 0.03); ?>
                    <?php if (($item['slug'] ?? '') === 'engineering') : ?>
                        <a class="resource-card" href="<?php echo esc_url(hc_page_url('contact')); ?>" style="display: block;">
                            <span><?php echo esc_html($item['type']); ?></span>
                            <h3><?php echo esc_html($item['title']); ?></h3>
                            <p><?php echo esc_html($item['description']); ?></p>
                        </a>
                    <?php else : ?>
                        <button
                            type="button"
                            class="resource-card"
                            data-resource-card="<?php echo esc_attr($item['slug']); ?>"
                            data-resource-title="<?php echo esc_attr($item['title']); ?>"
                        >
                            <span><?php echo esc_html($item['type']); ?></span>
                            <h3><?php echo esc_html($item['title']); ?></h3>
                            <p><?php echo esc_html($item['description']); ?></p>
                        </button>
                    <?php endif; ?>
                <?php hc_reveal_close(); ?>
            <?php endforeach; ?>
        </div>
        <p class="notice resource-notice" role="status" data-resource-notice hidden>
            “<span data-resource-label></span>” is a frontend placeholder.
            Downloadable files will be connected in a later phase.
            <a href="<?php echo esc_url(hc_page_url('resources')); ?>">Open the resources desk</a>.
        </p>
    </div>
</section>
