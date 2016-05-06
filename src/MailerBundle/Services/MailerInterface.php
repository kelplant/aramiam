<?php
namespace  MailerBundle\Services;

interface MailerInterface
{
    public function sendInfosMessage($numUser, $to);
}