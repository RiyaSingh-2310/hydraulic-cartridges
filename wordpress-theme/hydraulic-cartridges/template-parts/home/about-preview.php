<?php
$images = hc_images();
$about  = $images['about'] ?? array('src' => '', 'alt' => '');
?>
<section class="section" style="background: var(--white);">
    <div class="container about-editorial">
        <?php hc_reveal_open(); ?>
            <p class="eyebrow">About</p>
            <h2 class="display">A manufacturer for engineers who specify, not browse.</h2>
            <p class="lede" style="margin-top: 1rem;">
                The company exists to put precision cartridges into OEM manifolds with a short path from
                application question to machined part.
            </p>
            <div class="hero-actions">
                <?php hc_btn(hc_page_url('about'), 'Read the philosophy', 'outline'); ?>
            </div>
        <?php hc_reveal_close(); ?>
        <?php hc_reveal_open(0.08); ?>
            <div class="split-media" style="min-height: 24rem;">
                <img src="<?php echo esc_url($about['src']); ?>" alt="<?php echo esc_attr($about['alt']); ?>" loading="lazy" />
            </div>
        <?php hc_reveal_close(); ?>
    </div>
</section>
