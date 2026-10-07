<?php
/**
 * Catalog helpers — families, URLs, queries.
 */

if (! defined('ABSPATH')) {
    exit;
}

function hc_family_taxonomy() {
    return 'hc_family';
}

function hc_family_link($term) {
    if (! $term) {
        return hc_products_url();
    }
    $link = get_term_link($term, hc_family_taxonomy());
    return is_wp_error($link) ? hc_products_url() : $link;
}

function hc_get_family_terms($parent = 0) {
    $terms = get_terms(array(
        'taxonomy'   => hc_family_taxonomy(),
        'hide_empty' => false,
        'parent'     => (int) $parent,
        'orderby'    => 'none',
        'number'     => 0,
    ));
    if (is_wp_error($terms) || ! $terms) {
        return array();
    }
    usort($terms, function ($a, $b) {
        $ao = (int) get_term_meta($a->term_id, 'order', true);
        $bo = (int) get_term_meta($b->term_id, 'order', true);
        if ($ao === $bo) {
            return strcasecmp($a->name, $b->name);
        }
        return $ao <=> $bo;
    });
    return $terms;
}

function hc_catalog_tree() {
    $parents = hc_get_family_terms(0);
    $tree    = array();
    foreach ($parents as $parent) {
        $tree[] = array(
            'term'     => $parent,
            'children' => hc_get_family_terms($parent->term_id),
        );
    }
    return $tree;
}

function hc_family_url_by_slug($slug) {
    $term = get_term_by('slug', $slug, hc_family_taxonomy());
    if ($term && ! is_wp_error($term)) {
        return hc_family_link($term);
    }
    return home_url(user_trailingslashit('products/' . ltrim($slug, '/')));
}

function hc_catalog_display_tree() {
    $live = hc_catalog_tree();
    if ($live) {
        $out = array();
        foreach ($live as $branch) {
            $children = array();
            foreach ($branch['children'] as $child) {
                $children[] = array(
                    'name'   => $child->name,
                    'slug'   => $child->slug,
                    'intro'  => hc_term_intro($child),
                    'visual' => hc_term_visual($child),
                    'url'    => hc_family_link($child),
                );
            }
            $out[] = array(
                'name'     => $branch['term']->name,
                'slug'     => $branch['term']->slug,
                'intro'    => hc_term_intro($branch['term']),
                'visual'   => hc_term_visual($branch['term']),
                'url'      => hc_family_link($branch['term']),
                'children' => $children,
            );
        }
        return $out;
    }

    $out = array();
    foreach (hc_catalog_blueprint() as $family) {
        $children = array();
        foreach ($family['children'] as $child) {
            $children[] = array(
                'name'   => $child['name'],
                'slug'   => $child['slug'],
                'intro'  => $child['intro'] ?? '',
                'visual' => $child['visual'] ?? $family['visual'],
                'url'    => hc_family_url_by_slug($child['slug']),
            );
        }
        $out[] = array(
            'name'     => $family['name'],
            'slug'     => $family['slug'],
            'intro'    => $family['intro'] ?? '',
            'visual'   => $family['visual'] ?? 'cartridge',
            'url'      => hc_family_url_by_slug($family['slug']),
            'children' => $children,
        );
    }
    return $out;
}

function hc_catalog_explorer_tree() {
    static $cached = null;
    if (null !== $cached) {
        return $cached;
    }

    $tree     = hc_catalog_display_tree();
    $by_group = array();

    $query = new WP_Query(array(
        'post_type'      => 'hc_product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    ));
    foreach ($query->posts as $post) {
        $terms = get_the_terms($post->ID, hc_family_taxonomy());
        if (! $terms || is_wp_error($terms)) {
            continue;
        }
        $item = array(
            'name'  => $post->post_title,
            'url'   => get_permalink($post),
            'model' => (string) get_post_meta($post->ID, '_hc_model', true),
        );
        foreach ($terms as $term) {
            if ((int) $term->parent > 0) {
                $by_group[ $term->slug ][] = $item;
            }
        }
    }
    wp_reset_postdata();

    if (! $by_group) {
        foreach (hc_catalog_blueprint() as $family) {
            foreach ($family['children'] as $child) {
                $items = array();
                foreach ($child['products'] ?? array() as $product) {
                    $items[] = array(
                        'name'  => $product['name'],
                        'model' => $product['model'] ?? '',
                        'url'   => home_url(user_trailingslashit('products/' . $family['slug'] . '/' . $child['slug'] . '/' . $product['slug'])),
                    );
                }
                if (! $items) {
                    $items[] = array(
                        'name'  => $child['name'],
                        'model' => '',
                        'url'   => hc_family_url_by_slug($child['slug']),
                    );
                }
                $by_group[ $child['slug'] ] = $items;
            }
        }
    }

    foreach ($tree as &$family) {
        foreach ($family['children'] as &$child) {
            $child['products'] = $by_group[ $child['slug'] ] ?? array();
        }
    }
    unset($family, $child);

    $cached = $tree;
    return $cached;
}

function hc_term_intro($term) {
    if (! $term) {
        return '';
    }
    $meta = get_term_meta($term->term_id, '_hc_intro', true);
    if ($meta) {
        return $meta;
    }
    return $term->description;
}

function hc_term_visual($term) {
    $visual = $term ? get_term_meta($term->term_id, '_hc_visual', true) : '';
    return $visual ? $visual : 'cartridge';
}

function hc_products_in_term($term, $include_children = true) {
    if (! $term) {
        return array();
    }
    $query = new WP_Query(array(
        'post_type'      => 'hc_product',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
        'no_found_rows'  => true,
        'tax_query'      => array(
            array(
                'taxonomy'         => hc_family_taxonomy(),
                'field'            => 'term_id',
                'terms'            => (int) $term->term_id,
                'include_children' => $include_children,
            ),
        ),
    ));
    $items = array();
    foreach ($query->posts as $post) {
        $items[] = hc_product_from_post($post);
    }
    wp_reset_postdata();
    return $items;
}

function hc_product_family_terms($post_id) {
    $terms = get_the_terms($post_id, hc_family_taxonomy());
    if (! $terms || is_wp_error($terms)) {
        return array('family' => null, 'group' => null);
    }
    $group  = null;
    $family = null;
    foreach ($terms as $term) {
        if ((int) $term->parent > 0) {
            $group = $term;
        } else {
            $family = $term;
        }
    }
    if ($group && ! $family) {
        $family = get_term($group->parent, hc_family_taxonomy());
    }
    return array('family' => $family, 'group' => $group);
}

function hc_is_products_context() {
    return is_post_type_archive('hc_product')
        || is_singular('hc_product')
        || is_tax(hc_family_taxonomy());
}

function hc_listing_card($product) {
    if (! $product) {
        return;
    }
    ?>
    <article class="product-card listing-card">
        <div class="product-card-visual">
            <?php hc_product_visual($product['visual'], $product['name']); ?>
        </div>
        <div class="product-card-body">
            <p class="meta"><?php echo esc_html(($product['model'] ? $product['model'] . ' · ' : '') . $product['category']); ?></p>
            <h3><?php echo esc_html($product['name']); ?></h3>
            <?php if ($product['shortDescription']) : ?>
                <p><?php echo esc_html($product['shortDescription']); ?></p>
            <?php endif; ?>
            <div class="spec-row">
                <?php if ($product['pressure']) : ?><span><?php echo esc_html($product['pressure']); ?></span><?php endif; ?>
                <?php if ($product['flow']) : ?><span><?php echo esc_html($product['flow']); ?></span><?php endif; ?>
            </div>
            <p class="cart-price">On request</p>
            <div class="product-card-actions" data-product-actions>
                <a class="btn btn-outline" href="<?php echo esc_url($product['permalink']); ?>">View details</a>
                <?php hc_add_to_cart_button($product); ?>
            </div>
        </div>
    </article>
    <?php
}

function hc_family_card($term, $child_count = 0) {
    $intro = hc_term_intro($term);
    ?>
    <a class="family-card" href="<?php echo esc_url(hc_family_link($term)); ?>">
        <div class="family-card-visual">
            <?php hc_product_visual(hc_term_visual($term), $term->name); ?>
        </div>
        <div class="family-card-body">
            <p class="eyebrow"><?php echo esc_html($child_count ? sprintf('%d groups', $child_count) : 'Product group'); ?></p>
            <h3><?php echo esc_html($term->name); ?></h3>
            <?php if ($intro) : ?>
                <p><?php echo esc_html($intro); ?></p>
            <?php endif; ?>
            <span class="explore-link">View range →</span>
        </div>
    </a>
    <?php
}
