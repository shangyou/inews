<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="robots" content="all" />
    <title><?php echo $title . ' ' . $config['site']['title_suffix']; ?></title>
    <meta name="viewport" content="initial-scale=1.0" />
    <?php // add a right description
    $meta_des = $config['site']['default_meta'];
    if(isset($article)) $meta_des = $article->title . ': ' . mb_substr($article->content, 0 , 80);
    ?>
    <meta name="description" content="<?php echo str_replace("\n","", strip_tags($meta_des)); ?>"/>
    <meta name="keyword" content="<?php echo $config['site']['keywords']; ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS Feed" href="<?php echo url('/feed', null, true); ?>" />
    <link rel="stylesheet" href="/static/style.css" />
    <link rel="icon shortcut" href="/favicon.png"/>
    <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
</head>
<body>

<header id="header">
    <menu class="wrapper clearfix">
        <?php
        $menus = config('site.menus');
        $focus = null;
        if ($menus): foreach ($menus as $menu) {
            if (app()->input->path() == $menu[1]) {
                $focus = $menu[1];
                break;
            }
        } endif;
        ?>
        <li<?php if (!$focus): ?> class="on"<?php endif; ?>><a href="/"><i class="font font-monitor"></i> <?php echo $config['site']['title']; ?></a></li>
        <?php if ($menus): foreach ($menus as $i => $menu): ?>
            <li<?php if ($focus == $menu[1]): ?> class="on"<?php endif; ?>><a href="<?php echo $menu[1]; ?>"<?php if ($i > 0) { echo ' class="topuser"'; } ?>><i class="font<?php if (!empty($menu[2])){ echo ' font-' . $menu[2]; } ?>"></i> <?php echo $menu[0]; ?></a></li>
        <?php endforeach; endif; ?>
        <li class="submit"><a href="/submit"><i class="font font-edit"></i> Share one</a></li>
    </menu>
</header>

<?php
$ua = $_SERVER['HTTP_USER_AGENT'];
if(preg_match('/!(?:Macintosh|Opera|Safari|Chrome|Firefox|(?:MSIE\s(10|9)))/', $ua)): ?>
    <div class="wrapper wrapper-padding">
        <p>Hi there, u need a better browser to access the site, try: </p>
        <a href="https://www.mozilla.org/en-US/firefox/fx/">Firefox</a>,
        <a href="https://www.google.com/intl/en/chrome/browser/">Chrome</a>,
        <a href="http://www.apple.com/safari/">Safari</a>,
        <a href="http://www.opera.com">Opera</a> or
        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">IE 9/10</a>.
    </div>
<?php   die();
endif; ?>

<div class="wrapper user">
    <?php if ($user):
        $message = $user->isUnVerified() ? 'please <span class="highlight">verify</span> your <addr title="'. $user->email . '">email</addr>(<a href="/account/resend">resend</a>)' :
            'glad to see u'; ?>
        Hi <a href="/u/<?php echo $user->id; ?>"><?php echo $user->name; ?></a> <sup><a class="highlight-ok" title="it's not me" href="/account/logout">leave</a></sup>, <?php echo $message; ?>! Here is your
            <a href="/my/diggs">diggs</a>,
            <a href="/my/posts">posts</a>,
            <a href="/my/comments">comments</a>,
            <a href="/my/notice">notifications
            <?php if ($unread_count = $user->unreadNotifyCount()): ?><span id="notice" class="badge"><?php echo $unread_count; ?></span><?php endif; ?>
            </a>.
    <?php else: ?>
        Hi there. u can <a href="/account/login">signin</a>
        <?php if ($passport = config('passport')): foreach (config('passport') as $key => $null): ?>
        , with <a href="/login/<?php echo $key; ?>"><?php echo $key; ?></a>
        <?php endforeach;endif; ?>
        or <a href="/account/register">signup</a> as a member of the community.
    <?php endif; ?>
</div>

<div class="wrapper list">
    <?php if(isset($articles)) { ?>
        <div class="tools news">
            <form action="/search" class="news-item">
                <small class="pull-right">
                    <?php echo config('site.search_bar'); ?>
                    <a href="javascript:(function(d,s){ window.site_url = '<?php echo Pagon\Url::site(); ?>'; s = d.createElement('script');s.src='<?php echo Pagon\Url::site(); ?>/static/bml.js';d.head.appendChild(s);})(document);" class="tag tag-ok">分享到<?php echo config('site.title'); ?></a> ←拖到书签栏
                </small>
                <i class="font font-quote"></i>
                <input type="text" name="kw" placeholder="type to search..." required />
            </form>
        </div>
    <?php } ?>
    <?php echo $body;?>
</div>

<footer class="wrapper">
    &copy; Copyright <?php echo date('Y') . ' ' . $config['site']['title']; ?>, Powered by <a href="http://inews.io" title="inews.io">iNews.io</a>.&nbsp;
    <?php echo $config['site']['footer']; ?>
</footer>

<div class="modal hide" id="modal-shortcut">
    <h3 class="modal-header">Keyboard Shortcuts:
        <span class="close" data-dismiss="modal">&times;</span>
    </h3>
    <div class="modal-body">
        <ul class="clearfix shortcut">
            <li><i class="key">shift + ?</i> open/close shortcut menu</li>
            <li><i class="key">n</i> share a news</li>
            <li><i class="key">t</i> back to top</li>
            <li><i class="key">l</i> latest news</li>
            <li><i class="key">h</i> go home</li>
            <li><i class="key">m</i> mark all as read (notice)</li>
            <li><i class="key">&larr;</i> previous news (article)</li>
            <li><i class="key">&rarr;</i> next news (article)</li>
            <li><i class="key">esc</i> close/open shortcut menu</li>
            <li><i class="key">b</i> boss key</li>
        </ul>
    </div>
</div>

<script type="text/javascript" src="/static/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/static/mouse.js"></script>
<script type="text/javascript" src="/static/jquery.autosize-min.js"></script>
<script type="text/javascript" src="/static/bootstrap.js"></script>
<script type="text/javascript" src="/static/validator.js"></script>
<script type="text/javascript" src="/static/app.js"></script>
<?php if (!empty($config['ga'])): ?>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', '<?php echo $config['ga']; ?>']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<?php endif; ?>
</body>
</html>
