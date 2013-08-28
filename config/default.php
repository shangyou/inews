<?php
/**
 * Don't change this file
 *
 * If u want change, add this config on your config and change it.
 */

return array(
    /**
     * Site config
     */
    'site'          => array(
        // Site title, will display on home menu
        'title'        => 'iNews',
        // SEO title suffix for SEO
        'title_suffix' => '- Mac/iOS news',
        // Will output on non-article page for SEO
        'default_meta' => 'Upcoming Mac/iOS news for you, Daily Mac/iOS tips to live life easy.',
        // for SEO
        'keywords'     => 'Mac, iOS, iPhone tips, Mac tips, iOS tips, inews.io, inews',
        // footer display on every page
        'footer'       => '',
        // Search bar content
        'search_bar'   => '<a href="/p/406">简介</a> | <a href="https://github.com/Trimidea/inews-community/issues" target="_blank">反馈</a> | ',
        // Menus
        'menus'        => array(
            array('Latest', '/latest', 'clock'),
            array('Leaders', '/leaders', 'user'),
        )
    ),

    /**
     * GA id for analysis
     */
    'ga'            => false,

    /**
     * Timezone set
     */
    'timezone'      => 'Asia/Shanghai',

    /**
     * Views template directory
     */
    'views'         => dirname(__DIR__) . '/views',

    /**
     * Autoload directory path
     */
    'autoload'      => dirname(__DIR__) . '/src',

    /**
     * Password salt
     */
    'password_salt' => 'D#FA#!#%Nz',

    /**
     * Cookie config
     */
    'cookie'        => array(
        'path'     => '/',
        'domain'   => null,
        'secure'   => false,
        'httponly' => false,
        'timeout'  => 3600,
        'sign'     => false,
        'secret'   => 'DF@#dda#F^!',
        'encrypt'  => false,
    ),

    /**
     * Cryptor config
     */
    'crypt'         => array(
        'key' => 'sdF!#$FDA'
    ),

    /**
     * Is enable mail verify for user
     */
    'verify_user'   => false,

    /**
     * Sendgrid config, If not set, verify-mail can not send.
     */
    'sendgrid'      => array(
        'username' => '',
        'password' => '',
    ),

    /**
     * The admins fill with username
     */
    'admins'        => array(
        'admin'
    ),

    /**
     * Passport for 3rd
     */
    'passport'      => array(
        'sinaweibo' => array(
            'key'    => '2949574903',
            'secret' => '86aaebd2ac368208efc10eca65961e2e'
        )
    )
);