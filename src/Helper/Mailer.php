<?php

namespace Helper;

use PHPMailer;

class Mailer extends PHPMailer
{
    protected $options = array(
        'type'    => 'sendmail',
        'charSet' => 'utf-8'
    );

    protected $mailer;

    public function __construct(array $options = array())
    {
        $this->options = $options + $this->options;

        parent::__construct();

        $this->configureMailer();
    }

    /**
     * Configure the mailer
     *
     * @throws \InvalidArgumentException
     */
    protected function configureMailer()
    {
        switch ($this->options['type']) {
            case 'smtp':
                $this->IsSMTP();
                break;
            case 'sendmail':
            default:
                $this->IsSendmail();
                break;
        }

        // Set option of mailer
        foreach ($this->options as $key => $value) {
            $key = ucfirst($key);
            if (isset($this->{$key})) {
                $this->$key = $value;
            }
        }

        // Default use html
        $this->IsHTML(true);
    }

    /**
     * Set subject
     *
     * @param string $text
     * @return $this
     */
    public function subject($text)
    {
        $this->Subject = $text;
        return $this;
    }

    /**
     * Set html body
     *
     * @param string $html
     * @return $this
     */
    public function html($html)
    {
        $this->MsgHTML($html);
        return $this;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return $this
     */
    public function text($text)
    {
        $this->AltBody = $text;
        return $this;
    }

    /**
     * Add send to address
     *
     * @param        $address
     * @param string $name
     * @return $this
     */
    public function to($address, $name = '')
    {
        $this->AddAddress($address, $name);
        return $this;
    }

    /**
     * Set from
     *
     * @param string $address
     * @param string $name
     * @return $this
     */
    public function from($address, $name = '')
    {
        $this->SetFrom($address, $name);
        return $this;
    }

    /**
     * Add CC
     *
     * @param        $address
     * @param string $name
     * @return $this
     */
    public function cc($address, $name = '')
    {
        $this->AddCC($address, $name);
        return $this;
    }

    /**
     * Add BCC
     *
     * @param        $address
     * @param string $name
     * @return $this
     */
    public function bcc($address, $name = '')
    {
        $this->AddBCC($address, $name);
        return $this;
    }

    /**
     * Add attachments
     *
     * @param        $path
     * @param string $name
     * @return $this
     */
    public function attachment($path, $name = '')
    {
        $this->AddAttachment($path, $name);
        return $this;
    }

    /**
     * Send mail
     *
     * @return bool
     */
    public function send()
    {
        return parent::Send();
    }
}