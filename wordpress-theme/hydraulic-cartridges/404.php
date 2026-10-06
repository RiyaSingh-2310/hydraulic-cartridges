<?php
get_header();
hc_page_hero(
    '404',
    'This cavity is empty.',
    'The page does not exist in this frontend. Return to the catalog or send a quote request.'
);
?>
<section class="section" style="padding-top: 0;">
    <div class="container hero-actions">
        <?php hc_btn(home_url('/'), 'Home'); ?>
        <?php hc_btn(hc_products_url(), 'Products', 'outline'); ?>
        <a href="<?php echo esc_url(hc_page_url('contact')); ?>">Contact</a>
    </div>
</section>
<?php
get_footer();
