</main>
<footer class="site-footer">
    <div class="container-wide">
        <div class="footer-grid">
            <div class="footer-brand footer-col">
                <?php hc_logo_markup(); ?>
                <p>
                    Direct-from-manufacturer hydraulic cartridges and custom manifold components for
                    continuous-duty industrial equipment.
                </p>
                <p><?php echo esc_html(hc_company('iso')); ?></p>
            </div>
            <div class="footer-col">
                <h2>Products</h2>
                <a href="<?php echo esc_url(hc_products_url()); ?>">Cartridge catalog</a>
                <?php
                $screw = hc_get_product_by_slug('screw-in-cartridge-valves');
                $custom = hc_get_product_by_slug('custom-hydraulic-solutions');
                ?>
                <a href="<?php echo esc_url($screw ? $screw['permalink'] : hc_products_url()); ?>">Screw-in valves</a>
                <a href="<?php echo esc_url($custom ? $custom['permalink'] : hc_products_url()); ?>">Custom solutions</a>
                <a href="<?php echo esc_url(hc_quote_url()); ?>">Request a quote</a>
            </div>
            <div class="footer-col">
                <h2>Company</h2>
                <?php hc_primary_nav(); ?>
                <a href="<?php echo esc_url(hc_page_url('about')); ?>">Engineering</a>
            </div>
            <div class="footer-col">
                <h2>Contact</h2>
                <p>
                    <a href="<?php echo esc_url('mailto:' . hc_company('email')); ?>"><?php echo esc_html(hc_company('email')); ?></a>
                </p>
                <p>
                    <a href="<?php echo esc_url(hc_phone_href()); ?>"><?php echo esc_html(hc_company('phone')); ?></a>
                </p>
                <p><?php echo esc_html(hc_company('address')); ?></p>
                <p>Social — placeholder (LinkedIn / YouTube)</p>
            </div>
        </div>
        <div class="footer-meta">
            <p>© <?php echo esc_html(gmdate('Y')); ?> Hydraulic Cartridges. All rights reserved.</p>
            <div class="footer-legal">
                <a href="<?php echo esc_url(hc_page_url('privacy')); ?>">Privacy policy</a>
                <a href="<?php echo esc_url(hc_page_url('terms')); ?>">Terms</a>
            </div>
        </div>
    </div>
</footer>
<?php hc_render_cart_drawer(); ?>
<?php wp_footer(); ?>
</body>
</html>
