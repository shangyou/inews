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
        // Site title, will display on every page top
        'title'        => 'Mac/iOS news',
        // SEO title suffix for SEO
        'title_suffix' => '- Mac/iOS news',
        // Will output on non-article page for SEO
        'default_meta' => 'Upcoming Mac/iOS news for you, Daily Mac/iOS tips to live life easy.',
        // for SEO
        'keywords'     => 'Mac, iOS, iPhone tips, Mac tips, iOS tips, inews.io, inews',
        // footer display on every page
        'footer'       => '&copy; Copyright ' . date('Y') . ' Trimidea(<a href="mailto:trimidea@gmail . com">contact</a>), <span class="extra">Hosted on </span><a href="http://www.elinkvps.com/aff.php?aff=038">ELINKVPS</a>.'
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
    )
);