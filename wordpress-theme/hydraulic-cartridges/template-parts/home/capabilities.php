<?php $capabilities = hc_get_capabilities(); ?>
<section class="section capabilities">
    <div class="container">
        <?php
        hc_section_header(
            'Capabilities',
            'The manufacturing argument',
            'A cartridge is only as trustworthy as the cavity, the seat, the test, and the engineer who selected it.',
            true
        );
        ?>
        <div class="cap-grid">
            <?php foreach ($capabilities as $index => $item) : ?>
                <?php hc_reveal_open($index * 0.04, 'cap-item'); ?>
                    <p class="idx"><?php echo esc_html($item['index']); ?></p>
                    <h3><?php echo esc_html($item['title']); ?></h3>
                    <p><?php echo esc_html($item['description']); ?></p>
                <?php hc_reveal_close(); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
