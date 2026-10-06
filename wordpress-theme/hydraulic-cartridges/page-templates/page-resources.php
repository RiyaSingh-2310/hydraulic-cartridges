<?php
/**
 * Template Name: Resources
 */

get_header();
$resources = hc_get_resources();
$faqs      = hc_get_faqs();
hc_page_hero(
    'Resources',
    'Documentation for specification work',
    'Use these desks as a map of what will ship as files later. Until then, product pages carry the structured mock specifications.'
);
?>
<section class="section">
    <div class="container">
        <div class="resource-grid">
            <?php foreach ($resources as $item) : ?>
                <?php if (($item['slug'] ?? '') === 'engineering') : ?>
                    <a class="resource-card" href="<?php echo esc_url(hc_page_url('contact')); ?>">
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
            <?php endforeach; ?>
        </div>
        <p class="notice resource-notice" role="status" data-resource-notice hidden>
            Downloadable “<span data-resource-label></span>” files are not
            connected yet. This is a visual placeholder for the resources architecture.
        </p>
    </div>
</section>
<section class="section" style="padding-top: 0;">
    <div class="container">
        <h2 class="display" style="font-size: 2rem; margin-bottom: 1rem;">FAQs</h2>
        <div class="faq-list">
            <?php foreach ($faqs as $item) : ?>
                <details>
                    <summary><?php echo esc_html($item['question']); ?></summary>
                    <p><?php echo esc_html($item['answer']); ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
get_footer();
