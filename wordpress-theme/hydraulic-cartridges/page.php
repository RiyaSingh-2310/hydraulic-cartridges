<?php
get_header();
while (have_posts()) {
    the_post();
    hc_page_hero('Hydraulic Cartridges', get_the_title(), wp_strip_all_tags(get_the_excerpt()));
    echo '<section class="section"><div class="container">';
    the_content();
    echo '</div></section>';
}
get_footer();
