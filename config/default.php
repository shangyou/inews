<?php

return array(
    'site'     => array(
        'title'        => 'Mac/iOS news',
        'title_suffix' => '- Mac/iOS news',
        'default_meta' => 'Upcoming Mac/iOS news for you, Daily Mac/iOS tips to live life easy.',
        'keywords'     => '',
        'footer'       => '&copy; Copyright ' . date('Y') . ' Trimidea(<a href="mailto:trimidea@gmail . com">contact</a>), <span class="extra">Hosted on </span><a href="http://www.elinkvps.com/aff.php?aff=038">ELINKVPS</a>.'
    ),
    'ga'       => false,
    'timezone' => 'Asia/Shanghai',
    'views'    => dirname(__DIR__) . '/views',
    'autoload' => dirname(__DIR__) . '/src',
    'salt'     => 'D#FA#!#%Nz',
    'cookie'   => array(
        'path'     => '/',
        'domain'   => null,
        'secure'   => false,
        'httponly' => false,
        'timeout'  => 3600,
        'sign'     => false,
        'secret'   => 'DF@#dda#F^!',
        'encrypt'  => false,
    ),
    'crypt'    => array(
        'key' => 'sdF!#$FDA'
    ),
    'sendgrid' => array(
        'username' => '',
        'password' => '',
    ),
    'admins'   => array(
        'admin'
    )
);