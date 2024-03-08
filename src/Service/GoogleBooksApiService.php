<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleBooksApiService
{
   public function __construct(private readonly HttpClientInterface $googlebooksClient)
   {
   }

   public function search(string $search)
   {
       if (strlen($search) < 3) {
           return [];
       }

       return $this->makeRequest('GET', 'volumes', [
            'query' => [
                'q' => $search,
                //'maxResults' => 10
            ]
       ]);
   }

   public function makeRequest(string $method, $url, $options = []): array
   {
        $response = $this->googlebooksClient->request($method, $url, $options);
        return $response->toArray();
   }
}