<?php
/**
 * Functions and hooks relating to Beaver Builder.
 */

/**
 * @param object $form The module form object.
 * @param string $id   The module ID.
 *
 * @return object
 */
add_filter('fl_builder_register_settings_form', function ($form, $id) {
    if (! in_array($id, ['button', 'buttons_form', 'cta', 'row'], true)) {
        return $form;
    }

    // Button presets stuff.
    $presets = fs_get_bb_button_presets();
    if (empty($presets)) {
        return $form;
    }

    $preset_field_options = [
        'default'  => 'No Preset',
    ];
    foreach ($presets as $key => $preset) {
        $preset_field_options[$key] = $preset['name'];
    }

    $preset_field = [
        'button_preset' => [
            'type'    => 'select',
            'label'   => 'Button Preset',
            'default' => 'default',
            'options' => $preset_field_options,
        ],
    ];

    switch ($id) {
        case 'row':
            // General BB row preset.
            $row_presets_field = [
                'row_class' => [
                    'type' => 'select',
                    'label' => 'Row Style Preset',
                    'default' => 'default',
                    'options' => fs_get_row_presets(),
                ]
            ];

            $form['tabs']['style']['sections']['general']['fields'] = array_merge(
                $row_presets_field,
                $form['tabs']['style']['sections']['general']['fields']
            );

            // Background preset field for rows.
            // phpcs:ignore Generic.Files.LineLength.TooLong
            $form['tabs']['style']['sections']['background']['fields']['bg_type']['options']['preset'] = 'Preset';
            $form['tabs']['style']['sections']['background']['fields']['bg_type']['toggle']['preset'] = [
                'fields' => [
                    'background_class',
                ],
            ];
            $form['tabs']['style']['sections']['background']['fields']['background_class'] = [
                'type' => 'select',
                'label' => 'Preset',
                'default' => 'default',
                'options' => fs_get_background_presets(),
            ];
            break;

        case 'button':
            $form['style']['sections']['style']['fields'] = array_merge(
                $preset_field,
                $form['style']['sections']['style']['fields'],
            );
            break;
        case 'buttons_form':
            $form['tabs']['style']['sections']['style']['fields'] = array_merge(
                $preset_field,
                $form['tabs']['style']['sections']['style']['fields'],
            );
            break;
        case 'cta':
            $form['button']['sections']['btn_text']['fields'] = array_merge(
                $preset_field,
                $form['button']['sections']['btn_text']['fields'],
            );
            break;
    }

    return $form;
}, 10, 2);

/**
 * Add classes to BB row.
 */
add_filter('fl_builder_row_attributes', function ($attrs, $row) {
    if ('row' !== $row->type) {
        return $attrs;
    }

    /* Add class for row preset */
    $row_class = $row->settings->row_class ?? null;
    if (!in_array($row_class, [null, 'default'], true)) {
        $attrs['class'][] = $row_class;
    }

    /* Add class for background preset */
    $bg_class = $row->settings->background_class ?? null;
    if (!in_array($bg_class, [null, 'default'], true)) {
        $attrs['class'][] = $bg_class;
    }

    return $attrs;
}, 10, 2);

/**
 * Set our custom button preset settings to Button module settings.
 */
function fs_set_button_preset($settings, $presets)
{
    if ('default' === $settings->button_preset) {
        return $settings;
    }

    $custom_settings = $presets[$settings->button_preset]['settings'];
    $custom_class = isset($presets[$settings->button_preset]['class'])
        ? $presets[$settings->button_preset]['class'] : '';

    foreach ($custom_settings as $key => $setting) {
        $settings->$key = $setting;
    }

    if ('' !== $custom_class && property_exists($settings, 'class')) {
        $settings->class .= $custom_class;
    }

    return $settings;
}

/**
 * Set our custom button preset settings to CTA module's button settings.
 */
function fs_set_cta_preset($settings, $presets)
{
    if ('default' === $settings->button_preset) {
        return $settings;
    }

    $custom_settings = $presets[$settings->button_preset]['settings'];
    $custom_class = isset($presets[$settings->button_preset]['class'])
        ? $presets[$settings->button_preset]['class'] : '';

    foreach ($custom_settings as $key => $setting) {
        $settings->{"btn_{$key}"} = $setting;
    }

    if ('' !== $custom_class && property_exists($settings, 'class')) {
        $settings->class .= $custom_class;
    }

    return $settings;
}

/**
 * Overriding Beaver Builder's Button Module's default settings
 *
 * @param object $settings The module settings object.
 *
 * @return object
 */
add_filter('fl_builder_node_settings', function ($settings) {
    if (false === property_exists($settings, 'type')) {
        return $settings;
    }

    if (! in_array($settings->type, ['button', 'button-group', 'cta'], true)) {
        return $settings;
    }

    $presets = fs_get_bb_button_presets();
    if (empty($presets)) {
        return $settings;
    }

    switch ($settings->type) {
        case 'button':
            $settings = fs_set_button_preset($settings, $presets);
            break;
        case 'button-group':
            $settings->items = array_map(function ($item) use ($presets) {
                return fs_set_button_preset($item, $presets);
            }, $settings->items);
            break;
        case 'cta':
            $settings = fs_set_cta_preset($settings, $presets);
            break;
    }

    return $settings;
});
