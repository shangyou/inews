<?php

namespace Route\Api;

use Model\Notify;
use Route\Api;

class MarkRead extends Api
{
    protected $auth = true;

    public function post()
    {
        if (!$id = $this->input->data('id')) {
            $this->error('Param "notify_id" is needed');
        }

        if (!$notify = Notify::dispense()->find_one($id)) {
            $this->error('Notify is not exists');
        }

        if ($notify->user_id != $this->user->id) {
            $this->error('Only owner can be mark notify read');
        }

        if ($notify->isRead()) {
            $this->error('Already mark read');
        }

        $notify->markRead();
        $notify->save();
    }
}