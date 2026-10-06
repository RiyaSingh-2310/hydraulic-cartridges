<?php
/**
 * Fallback index.
 */

get_header();
if (have_posts()) {
    while (have_posts()) {
        the_post();
        hc_page_hero('Hydraulic Cartridges', get_the_title(), wp_strip_all_tags(get_the_excerpt() ?: get_the_content()));
        echo '<section class="section"><div class="container">';
        the_content();
        echo '</div></section>';
    }
} else {
    hc_page_hero('404', 'This cavity is empty.', 'The page does not exist.');
}
get_footer();
