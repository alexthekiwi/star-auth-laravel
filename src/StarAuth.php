<?php

namespace AlexClark\StarAuth;

use Illuminate\Support\Facades\Http;
use Illuminate\Auth\AuthenticationException;

class StarAuth
{
    protected $baseUrl;
    protected $token;

    public function __construct(string $url = '', string $token = '')
    {
        $this->baseUrl = $url ?? config('star-auth.url');
        $this->token = $token;
    }

    public function url(string $endpoint)
    {
        if (str_starts_with($endpoint, '/')) {
            $url = $this->baseUrl . $endpoint;
        } else {
            $url = $this->baseUrl . '/' . $endpoint;
        }

        return $url;
    }

    public function get(string $endpoint, $params = [])
    {
        $url = $this->url($endpoint);
        $res = Http::withToken($this->token)->get($url, $params);

        if ($res->failed()) {
            throw new AuthenticationException;
        }

        return $res->json();
    }

    public function post(string $endpoint, $params = [])
    {
        $url = $this->url($endpoint);
        $res = Http::withToken($this->token)->post($url, $params);

        if ($res->failed()) {
            throw new AuthenticationException;
        }

        return $res->json();
    }
}
