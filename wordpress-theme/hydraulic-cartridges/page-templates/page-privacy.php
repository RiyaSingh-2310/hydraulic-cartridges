<?php
/**
 * Template Name: Privacy
 */

get_header();
hc_page_hero(
    'Legal',
    'Privacy policy',
    'Placeholder policy for the frontend launch. Replace with counsel-approved text before production.',
    true
);
?>
<section class="section">
    <div class="container" style="max-width: 42rem;">
        <p>
            This website currently stores no account data and does not submit forms to a server.
            Quote and contact entries exist only in the browser session after validation.
        </p>
        <p style="margin-top: 1rem; color: var(--steel);">
            When a backend is connected, this page will describe what is collected, why, and how
            long it is retained.
        </p>
    </div>
</section>
<?php
get_footer();
