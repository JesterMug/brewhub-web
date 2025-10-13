<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;

class OrderMailer extends Mailer
{
    /**
     * Sends order confirmation email using the HTML template.
     *
     * @param string $toEmail Recipient email address
     * @param array $viewVars Variables for the email template
     * @return void
     */
    public function sendOrderConfirmation(string $toEmail, array $viewVars = []): void
    {
        $from = (string)Configure::read('Email.default.from', 'you@localhost');

        $this
            ->setTransport('default')
            ->setEmailFormat('html')
            ->setFrom($from, (string)Configure::read('App.title', 'Brewhub'))
            ->setTo($toEmail)
            ->setSubject('Your Order Confirmation')
            ->setViewVars($viewVars);

        $this->viewBuilder()
            ->setTemplate('order_confirmation')
            ->setLayout('default');

        $this->deliver();
    }
}
