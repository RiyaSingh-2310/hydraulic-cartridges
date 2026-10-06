<?php $applications = hc_get_applications(); ?>
<section class="section">
    <div class="container">
        <?php
        hc_section_header(
            'Industries',
            'Where the circuit lives',
            'Cartridge valves earn their place on machines that move load, hold pressure, and run without drama across shifts.',
            true
        );
        ?>
        <div class="applications-grid">
            <?php foreach ($applications as $index => $app) : ?>
                <?php hc_reveal_open($index * 0.03); ?>
                    <a class="app-panel" href="<?php echo esc_url($app['permalink']); ?>">
                        <img src="<?php echo esc_url($app['image']); ?>" alt="<?php echo esc_attr($app['imageAlt']); ?>" loading="lazy" />
                        <div class="app-panel-body">
                            <h3><?php echo esc_html($app['name']); ?></h3>
                            <p><?php echo esc_html($app['shortDescription']); ?></p>
                        </div>
                    </a>
                <?php hc_reveal_close(); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
