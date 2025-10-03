<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Log\Log;

class WebhooksController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->disableAutoLayout();
        $this->autoRender = false;
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Allow unauthenticated Stripe webhook calls
        $this->Authentication->addUnauthenticatedActions(['stripe']);
    }

    // Stripe webhook endpoint
    public function stripe()
    {
        $this->request->allowMethod(['post']);

        $endpointSecret = (string)Configure::read('Stripe.webhook_secret');
        if (empty($endpointSecret)) {
            return $this->response->withStatus(500)->withStringBody('Missing webhook secret');
        }

        // Retrieve the raw body for signature verification
        $stream = $this->request->getBody();
        if (method_exists($stream, 'rewind')) {
            $stream->rewind();
        }
        $payload = (string)$stream->getContents();
        $sigHeader = (string)$this->request->getHeaderLine('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::warning('Stripe webhook invalid payload: ' . $e->getMessage());
            return $this->response->withStatus(400)->withStringBody('Invalid payload');
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::warning('Stripe webhook signature verification failed: ' . $e->getMessage());
            return $this->response->withStatus(400)->withStringBody('Invalid signature');
        } catch (\Throwable $e) {
            Log::error('Stripe webhook unexpected error: ' . $e->getMessage());
            return $this->response->withStatus(400)->withStringBody('Webhook error');
        }

        // Handle the event
        $type = $event->type ?? '';
        Log::info('Stripe webhook received: ' . $type);

        switch ($type) {
            case 'checkout.session.completed':
                // TODO: Implement order fulfillment/payment confirmation logic
                break;
            case 'payment_intent.succeeded':
            case 'payment_intent.payment_failed':
            case 'charge.succeeded':
            case 'charge.failed':
            default:
                // For now, we just acknowledge receipt
                break;
        }

        return $this->response->withStatus(200)->withStringBody('success');
    }
}
