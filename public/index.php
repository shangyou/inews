<?php

/** @var $app \Pagon\App */
$app = include dirname(__DIR__) . '/bootstrap.php';

$app->add('Session\Cookie', array('lifetime' => 86400 * 7));

$app->get('/', '\Route\Web\Index');
$app->get('/latest', '\Route\Web\Latest');
$app->get('/leaders', '\Route\Web\Leader');
$app->all('/account/register', '\Route\Web\Account\Register');
$app->all('/account/login', '\Route\Web\Account\Login');
$app->all('/account/logout', '\Route\Web\Account\Logout');
$app->get('/account/verify', '\Route\Web\Account\Verify');
$app->get('/account/welcome', '\Route\Web\Account\Welcome');
$app->get('/account/resend', '\Route\Web\Account\ReSend');
$app->all('/account/edit', '\Route\Web\Account\Edit');

$app->all('/submit', '\Route\Web\Submit');
$app->get('/p/(:id)', '\Route\Web\Article');
$app->all('/p/(:id)/comment', '\Route\Web\Article\Comment');
$app->get('/p/(:id)/digg', '\Route\Web\Article\Digg');
$app->all('/p/(:id)/destroy', '\Route\Web\Article\Destroy');
$app->all('/p/(:id)/edit', '\Route\Web\Article\Edit');

$app->get('/u/(:id)', '\Route\Web\User');

$app->get('/my/posts', '\Route\Web\Account\Article');
$app->get('/my/diggs', '\Route\Web\Account\Digg');
$app->get('/my/comments', '\Route\Web\Account\Comment');
$app->all('/my/notice', '\Route\Web\Account\Notification');

$app->post('/api/digg', '\Route\Api\Digg');
$app->post('/api/notify/read', '\Route\Api\MarkRead');
$app->get('/api/nick', '\Route\Api\Nick');
$app->get('/api/alfred/(:type)', '\Route\Api\Alfred');

$app->get('/timeline', '\Route\Web\Apple');

$app->get('/user/(:id)', function ($req, $res) {
    $res->redirect('/u/' . $req->param('id'));
});

$app->get('/article/(:id)', function ($req, $res) {
    $res->redirect('/p/' . $req->param('id'));
});

$app->get('/robots.txt', function ($req, \Pagon\Http\Output $res) use ($app) {
    $page = __DIR__ . '/page/robots.txt';
    if (is_file($page . '.' . $app->mode())) {
        $page .= '.' . $app->mode();
    }
    $res->expires(3600);
    $res->contentType('txt');
    $res->render($page);
});

$app->run();