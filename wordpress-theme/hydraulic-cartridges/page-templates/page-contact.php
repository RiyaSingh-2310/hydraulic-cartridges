<?php
/**
 * Template Name: Contact
 */

get_header();
hc_page_hero(
    'Contact',
    'Speak with the engineering desk',
    'Use this form for application questions. Quotations with product and quantity should go through Request a Quote.'
);
?>
<section class="section">
    <div class="container detail-layout">
        <div>
            <p>
                Email <a href="<?php echo esc_url('mailto:' . hc_company('email')); ?>"><?php echo esc_html(hc_company('email')); ?></a>
            </p>
            <p style="margin-top: 0.5rem;">
                Phone <a href="<?php echo esc_url(hc_phone_href()); ?>"><?php echo esc_html(hc_company('phone')); ?></a>
            </p>
            <p style="margin-top: 1rem; color: var(--steel);"><?php echo esc_html(hc_company('address')); ?></p>
            <p style="margin-top: 0.5rem; color: var(--steel);"><?php echo esc_html(hc_company('hours')); ?></p>
        </div>
        <div>
            <div class="success-panel" data-contact-success hidden>
                <h2>Message recorded</h2>
                <p>
                    Thank you, <span data-contact-name></span>. This is a frontend-only confirmation. No backend is
                    connected yet. A production environment will route this to the engineering desk.
                </p>
            </div>
            <form class="form-grid" data-contact-form method="post" novalidate>
                <?php wp_nonce_field('hc_contact', 'hc_contact_nonce'); ?>
                <div class="field" data-field="name">
                    <label for="name">Name</label>
                    <input id="name" name="name" autocomplete="name" minlength="2" maxlength="35" />
                </div>
                <div class="field" data-field="email">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" />
                </div>
                <div class="field full" data-field="message">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" minlength="1"></textarea>
                </div>
                <div>
                    <button class="btn" type="submit" disabled>
                        <span data-btn-label>Send message</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
<?php
get_footer();
