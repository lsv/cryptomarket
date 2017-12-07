<?php

namespace App;

class MailerService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $mailToAddress;

    /**
     * @var string
     */
    private $mailToName;

    /**
     * @var string
     */
    private $mailSenderAddress;

    /**
     * @var string
     */
    private $mailSenderName;

    /**
     * @param \Swift_Mailer $mailer
     * @param string $mailToAddress
     * @param string $mailToName
     * @param string $mailSenderAddress
     * @param string $mailSenderName
     */
    public function __construct(\Swift_Mailer $mailer, $mailToAddress, $mailToName, $mailSenderAddress, $mailSenderName)
    {
        $this->mailer = $mailer;
        $this->mailToAddress = $mailToAddress;
        $this->mailToName = $mailToName;
        $this->mailSenderAddress = $mailSenderAddress;
        $this->mailSenderName = $mailSenderName;
    }

    public function send(\Swift_Message $message)
    {
        $message->setFrom($this->mailSenderAddress, $this->mailSenderName);
        $message->setTo($this->mailToAddress, $this->mailToName);
        $this->mailer->send($message);
    }

}