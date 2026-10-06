<?php
/**
 * Solutions / applications archive.
 */

get_header();
hc_page_hero(
    'Solutions',
    'Applications across industrial machinery',
    'The same cartridge families serve mobile frames, plant automation, energy auxiliaries, and specialized machines — selected by duty, not by fashion.'
);
$applications = hc_get_applications();
?>
<section class="section">
    <div class="container applications-grid">
        <?php foreach ($applications as $app) : ?>
            <a class="app-panel" href="<?php echo esc_url($app['permalink']); ?>">
                <img src="<?php echo esc_url($app['image']); ?>" alt="<?php echo esc_attr($app['imageAlt']); ?>" loading="lazy" />
                <div class="app-panel-body">
                    <h2><?php echo esc_html($app['name']); ?></h2>
                    <p><?php echo esc_html($app['shortDescription']); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php
get_footer();
