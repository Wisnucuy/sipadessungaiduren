<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Set some default values. It is possible to add all defines that can be set
    | in dompdf_config.inc.php. You can also override the entire config file.
    |
    */
    'show_warnings' => false,   // Throw an Exception on warnings from dompdf

    'public_path' => null,  // Override the public path if needed

    /*
     * Dejavu Sans font is missing glyphs for converted entities, turn it off if you need to show € and £.
     */
    'convert_entities' => true,

    'options' => [
    'font_dir'                => storage_path('fonts/'),
    'font_cache'              => storage_path('fonts/'),
    'temp_dir'                => sys_get_temp_dir(),
    'chroot'                  => realpath(base_path()),
    'allowed_protocols'       => [
        'file://' => ['rules' => []],
        'http://' => ['rules' => []],
        'https://' => ['rules' => []],
    ],
    'log_output_file'         => null,
    'font_height_ratio'       => 1.1,
    'enable_php'              => false,
    'enable_remote'           => true,    // ← ubah jadi true
    'enable_css_float'        => false,
    'enable_html5_parser'     => true,    // ← ubah jadi true
    'disable_ssl_verification' => false,
    'debugPng'                => false,
    'debugKeepTemp'           => false,
    'debugCss'                => false,
    'debugLayout'             => false,
    'debugLayoutLines'        => true,
    'debugLayoutBlocks'       => true,
    'debugLayoutInline'       => true,
    'debugLayoutPaddingBox'   => true,
    'dpi'                     => 96,
    'default_font_size'       => 12,
    'default_font'            => 'serif',
    'image_dpi'               => 96,
    'pdf_backend'             => 'CPDF',
    'pdffontpath'             => null,
],

];
