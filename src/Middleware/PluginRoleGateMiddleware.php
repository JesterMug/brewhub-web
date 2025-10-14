<?php
namespace App\Middleware;

use Cake\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PluginRoleGateMiddleware implements MiddlewareInterface
{
    public function __construct(private array $rules) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = rtrim($request->getUri()->getPath(), '/');
        if ($path === '/content-blocks') {

            return (new Response())
                ->withStatus(302)
                ->withHeader('Location', '/');
        }

        $identity = $request->getAttribute('identity');
        $role = $identity?->get('user_type');

        $params = $request->getAttribute('params') ?? [];
        $plugin = $params['plugin'] ?? null;

        if ($plugin && isset($this->rules[$plugin])) {
            $allowed = $this->rules[$plugin];
            if (!in_array($role, $allowed, true)) {
                return (new Response())
                    ->withStatus(302)
                    ->withHeader('Location', '/');
            }
        }

        return $handler->handle($request);
    }
}
