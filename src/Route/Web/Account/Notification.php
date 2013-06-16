<?php

namespace Route\Web\Account;

use Helper\Html;
use Model\Model;
use ORM;
use Route\Web;
use Model\Notify;

class Notification extends Web
{
    protected $auth = true;
    protected $tpl = 'account/notify.php';
    protected $title = 'Unread notifications';

    public function get()
    {
        if (($page = $this->input->query('page', 1)) < 1) $page = 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $is_read = is_null($this->input->query('read')) ? 0 : 1;
        $this->data['is_read'] = $is_read;
        $type = $is_read ? Notify::READ : Notify::UNREAD;

        $total = $this->user->notifies()->where('status', $type)->count();

        $this->data['notifies'] = $this->user->notifies()->where('status', $type)->offset($offset)->limit($limit)->order_by_desc('created_at')->find_many();

        $this->data['page'] = Html::makePage($this->input->uri(), 'page=(:num)', $page, $total, $limit);
    }

    public function post()
    {
        try {
            ORM::raw_execute('UPDATE `notify` SET `status` = ' . Notify::READ . ' WHERE user_id = ' . $this->user->id);
        } catch (\PDOException $e) {
            $this->alert('Mark all read error with bad database');
        }

        $this->redirect($this->input->refer());
    }
}