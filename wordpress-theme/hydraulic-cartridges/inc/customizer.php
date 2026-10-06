<?php
/**
 * Customizer: contact, footer, and identity fields.
 */

if (! defined('ABSPATH')) {
    exit;
}

add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('hc_company', array(
        'title'    => 'Hydraulic Cartridges',
        'priority' => 30,
    ));

    $fields = array(
        'hc_email'   => array('Email', hc_company('email'), 'email'),
        'hc_phone'   => array('Phone', hc_company('phone'), 'text'),
        'hc_address' => array('Address', hc_company('address'), 'textarea'),
        'hc_hours'   => array('Hours', hc_company('hours'), 'text'),
        'hc_iso'     => array('ISO statement', hc_company('iso'), 'textarea'),
    );

    foreach ($fields as $id => $cfg) {
        $wp_customize->add_setting($id, array(
            'default'           => $cfg[1],
            'sanitize_callback' => 'textarea' === $cfg[2] ? 'sanitize_textarea_field' : ('email' === $cfg[2] ? 'sanitize_email' : 'sanitize_text_field'),
            'transport'         => 'refresh',
        ));
        $control_class = 'textarea' === $cfg[2] ? 'WP_Customize_Control' : 'WP_Customize_Control';
        $wp_customize->add_control($id, array(
            'label'   => $cfg[0],
            'section' => 'hc_company',
            'type'    => $cfg[2],
        ));
        unset($control_class);
    }
});
