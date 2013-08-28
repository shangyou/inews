<?php

/** @var $app \Pagon\App */
$app = include dirname(__DIR__) . '/bootstrap.php';

$app->add('Session\Cookie', array('lifetime' => 86400 * 7));
$app->add('OPAuth', array(
    'security_salt' => 'LDFmiilYf8Fyw5W10rxx4W1KsVrieQCnpBzzpTBWA5vJidQKDx8pMJbmw28R1C4m',
    'Strategy'      => $app->get('passport'),
    'callback'      => '\Route\Web\Login\Callback'
));

$app->get('/', '\Route\Web\Index');
$app->get('/latest', '\Route\Web\Latest');
$app->get('/search', '\Route\Web\Search');
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
$app->get('/feed', '\Route\RssFeed');

$app->get('/user/(:id)', function ($req, $res) {
    $res->redirect('/u/' . $req->param('id'));
});

$app->run();