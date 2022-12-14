<?php

namespace App\Context\Rest\Common\Auth;


use App\Context\Rest\Common\AbstractRouteHandler;
use App\Context\Rest\Interfaces\HandlerParamsInterface;
use App\Context\Rest\Interfaces\RouteHandlerInterface;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class AuthHandler extends AbstractRouteHandler
{
    private const ROUTE = '/auth/token';
    private const URL   = 'http://sf-auth.devel/token';
    
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function handle(HandlerParamsInterface $params)
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                self::URL,
                [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                    ],
                    'body'    => $params->getParams()['post'],
                ]
            );
        } catch (ServerExceptionInterface|TransportExceptionInterface|ClientExceptionInterface $exception) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'errors' => [
                    'message' => $exception->getMessage(),
                ],
            ];
        }
        
        return [
            'response' => json_decode($response->getContent(), true),
        ];
    }
    
    public function support(HandlerParamsInterface $params): bool
    {
        return $params->getMethod() === Request::METHOD_POST &&
            $params->getBasePath() === self::ROUTE;
    }
    
    private function getOptions(): array
    {
        return [
            "grant_type"    => "client_credentials",
            "client_id"     => "05326983a2ca968b3b22a0bcf57bd5d9",
            "client_secret" => "a0fd43f1025b565db8680bc9cd9490187974e214117f53a8f55a228c8e97eb7f6c7d5f8e62556c74cf23e9ad4502ca448ff281a3ce6ce5abbaaa20b59986a38b",
        ];
    }
}
