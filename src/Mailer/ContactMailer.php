<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;

class ContactMailer extends Mailer
{
    /**
     * Send a confirmation email to the user who submitted the contact form.
     *
     * @param string $toEmail
     * @param array $viewVars
     * @return void
     */
    public function sendUserConfirmation(string $toEmail, array $viewVars = []): void
    {
        $from = (string)Configure::read('Email.default.from', 'you@localhost');

        $this
            ->setTransport('default')
            ->setEmailFormat('html')
            ->setFrom($from, (string)Configure::read('App.title', 'Brewhub'))
            ->setTo($toEmail)
            ->setSubject('We received your message — Brewhub')
            ->setViewVars($viewVars);

        $this->viewBuilder()
            ->setTemplate('contact_user')
            ->setLayout('default');

        $this->deliver();
    }

    /**
     * Send an admin notification about the contact form submission.
     *
     * @param string $adminEmail
     * @param array $viewVars
     * @param string|null $replyTo Optional reply-to (user's email)
     * @return void
     */
    public function sendAdminNotification(string $adminEmail, array $viewVars = [], ?string $replyTo = null): void
    {
        $from = (string)Configure::read('Email.default.from', 'system@brewhub.com');

        $this
            ->setTransport('default')
            ->setEmailFormat('html')
            ->setFrom($from, (string)Configure::read('App.title', 'Brewhub'))
            ->setTo($adminEmail)
            ->setSubject('New contact form submission — Brewhub')
            ->setViewVars($viewVars);

        if ($replyTo) {
            $this->setReplyTo($replyTo);
        }

        $this->viewBuilder()
            ->setTemplate('contact_admin')
            ->setLayout('default');

        $this->deliver();
    }
}
