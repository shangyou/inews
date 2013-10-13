# 配置环境

默认的配置目录为`./config`，默认配置为`default.php`，环境配置根据环境变量`PAGON_ENV`来调用

例如

```
export PAGON_ENV=production
```

此时，程序会加载`./config/production.php`合并`./config/default.php`作为配置

# 配置说明

```php
return array(
    /**
     * 网站配置
     */
    'site'          => array(
        // 网站标题，会出现在标题和网站Home菜单
        'title'        => 'iNews',
        // SEO标题后缀
        'title_suffix' => '- Mac/iOS news',
        // 非文章页面的META
        'default_meta' => 'Upcoming Mac/iOS news for you, Daily Mac/iOS tips to live life easy.',
        // SEO关键字
        'keywords'     => 'Mac, iOS, iPhone tips, Mac tips, iOS tips, inews.io, inews',
        // 页面底部配置，HTML代码
        'footer'       => '',
        // 搜索栏配置
        'search_bar'   => '<a href="/p/406">简介</a> | <a href="https://github.com/Trimidea/inews-community/issues" target="_blank">反馈</a> | ',
        // 菜单配置
        'menus'        => array(
            array('Latest', '/latest', 'clock'),
            array('Leaders', '/leaders', 'user'),
        )
    ),

    /**
     * Google统计的配置
     */
    'ga'            => false,

    /**
     * 时区配置
     */
    'timezone'      => 'Asia/Shanghai',

    /**
     * 默认的模板目录，一般不需要修改
     */
    'views'         => dirname(__DIR__) . '/views',

    /**
     * 自动加载路径，一般不需要修改
     */
    'autoload'      => dirname(__DIR__) . '/src',

    /**
     * 密码种子
     */
    'password_salt' => 'D#FA#!#%Nz',

    /**
     * COOKIE配置
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
     * 加密密钥配置
     */
    'crypt'         => array(
        'key' => 'sdF!#$FDA'
    ),

    /**
     * 是否开启邮件验证，如果开始，需要配置邮件，否则将无法使用
     */
    'verify_user'   => false,

    /**
     * 管理员列表，使用用户名
     */
    'admins'        => array(
        'admin'
    ),

    /**
     * 第三方登陆配置，目前仅支持Github和微博
     */
    /*'passport'      => array(
        'weibo'  => array(
            'key'            => '4001143741',
            'secret'         => 'ae6c0c7599e22f2fe0eb7726666cee32',
            'strategy_class' => 'SinaWeibo'
        ),
        'github' => array(
            'client_id'      => '48e6e90a1f919cbaeef5',
            'client_secret'  => 'a10c12531e6087ca056c3a9e50cb71c574f7c870',
            'strategy_class' => 'GitHub'
        )
    ),*/

    /**
     * 邮件配置，需要服务器配置好sendmail
     */
    /*'mail'          => array(
        'from'     => 'hfcorriez@gmail.com',
        'fromName' => 'iNews.io'
    )*/
);
```