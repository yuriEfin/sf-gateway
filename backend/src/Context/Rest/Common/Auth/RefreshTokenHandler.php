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

class RefreshTokenHandler extends AbstractRouteHandler
{
    private const ROUTE = '/auth/token/refresh';
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
                        'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIwNTMyNjk4M2EyY2E5NjhiM2IyMmEwYmNmNTdiZDVkOSIsImp0aSI6IjljNjRmM2YwYjliZmRlMjM3NzRlZmY4YTdmM2JiZWQxNjI4NmIwMzc4MWRjZjFjMjk4ZTQwOGViZTFjODJkZTZhZDQ1ZDNiN2IxNGFlOGU3IiwiaWF0IjoxNjY5MDQ5MTg2Ljk0NTIwNCwibmJmIjoxNjY5MDQ5MTg2Ljk0NTIxLCJleHAiOjE2NjkwNTI3ODYuOTQwMTU2LCJzdWIiOiIiLCJzY29wZXMiOlsiaWQiLCJlbWFpbCJdfQ.D9jzj-qaj9uhAbkIH4KYbTzD5qhI6-OHZX9wCCxvWACp2Hoz6NjfG5HNFHMueR1wFxzc812N1_EdUsilZgySCo-CtSMn8rg2WUboy_I-TnN8oHgT9mZduqB9uEQzhnZ9tIuAyv-lTgD4mAiga-LOBetnkZ2DwoKZtnkt8s3pB5AcNpbjaSeo79zT0XUMEgdVegZ-LHTMPgU_A7SJa01lBExS3iEPuA9FGRnKXLUEgHEv0FNjwfGBf6eli7fslZLWcHfE-tW7LhJoBok1g9O1M3BAPWIgkoiL1__OYTXFWoW1l05x-HHRt7YTlh7KyKlapMW9i2MjnvIZSHlSI2b4zQ'
                    ],
                    'body'    => $params->getParams(),
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
            "grant_type"    => "refresh_token",
            "client_id"     => "05326983a2ca968b3b22a0bcf57bd5d9",
            "client_secret" => "a0fd43f1025b565db8680bc9cd9490187974e214117f53a8f55a228c8e97eb7f6c7d5f8e62556c74cf23e9ad4502ca448ff281a3ce6ce5abbaaa20b59986a38b",
        ];
    }
}
