<?php

namespace Route;

use Pagon\Route\Rest;
use Pagon\View;
use Model\Model;

class Api extends Rest
{
    /**
     * @var array The data to use for template
     */
    protected $data = array(
        'result'  => true,
        'message' => 'ok',
        'error'   => 0
    );

    /**
     * @var \Model\User Login user
     */
    protected $user;

    /**
     * @var bool The page need auth
     */
    protected $auth = false;

    /**
     * Before logic
     */
    protected function before()
    {
        $this->loadOrm();

        $user_id = $this->input->session('login');

        if ($user_id) {
            $this->user = Model::factory('User')->find_one($user_id);
        }

        if ($this->auth) {
            $this->auth();
        }
    }

    /**
     * Auth
     */
    protected function auth()
    {
        if (!$this->user) {
            $this->error('This action need login');
        }
    }

    /**
     * Load ORM and database
     */
    protected function loadOrm()
    {
        $this->app->loadOrm();
    }

    /**
     * Show error
     *
     * @param string $message
     * @param int    $code
     */
    protected function error($message, $code = 1000)
    {
        $this->data['result'] = false;
        $this->data['message'] = $message;
        $this->data['error'] = $code;
        $this->after();
        $this->output->end();
    }

    /**
     * Show ok
     */
    protected function ok($message = 'ok')
    {
        $this->data['result'] = true;
        $this->data['message'] = $message;
        $this->after();
        $this->output->end();
    }

    /**
     * After logic
     */
    protected function after()
    {
        if ($this->input->query('format') == 'jsonp') {
            $this->output->jsonp($this->data, $this->input->query('cb', 'cb'));
        } else {
            $this->output->json($this->data);
        }
    }
}