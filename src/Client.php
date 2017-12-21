<?php

namespace InstagramAPI;

/**
 * A PHP cliente for Instagram API
 */
class Client
{
    /**
     * Array for config keys to call API
     * 
     * client_id
     * client_secret
     * acess_token
     * redirect_uri
     * scope
     *
     * @var [array]
     */
    private $config;

    /**
     * Property with client to make requests
     *
     * @var [GuzzleHttp\Client]
     */
    private $guzzleHttpClient;

    private $endpoints = [
        'auth' => 'https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&response_type=code&scope=%s',
        'access_token' => 'https://api.instagram.com/oauth/access_token',
        'media' => 'https://api.instagram.com/v1/media/%s/likes',
    ];

    public function __construct($config)
    {
        $this->config = $config;
        $this->guzzleHttpClient  = new \GuzzleHttp\Client;
    }

    /**
     * Create requests with Guzzle
     *
     * @param string $request_type
     * @param string $url
     * @param array $options
     * @return string
     */
    public function makeRequest(string $request_type, string $url, array $options): string
    {
        return (string) $this->guzzleHttpClient
        ->request($request_type, $url, $options)
        ->getBody();
    }
    
    /**
     * Returns a string with URI to log in and authorize application
     *
     * @return string
     */
    public function getAuthURI(): string
    {
        return sprintf($this->endpoints['auth'], $this->config['client_id'], $this->config['redirect_uri'], $this->config['scope']);
    }

    /**
     * After authorization, request a access_token to call api endpoints
     *
     * @param string $code
     * @return void
     */
    public function requestAccessToken(string $code): void
    {
        $options = [
            'client_id'     => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => $this->config['redirect_uri'],
            'code'          => $code,
        ];

        $requestAccessToken = $this->makeRequest('POST', $this->endpoints['access_token'], ['form_params' => $options]);

        $this->setAccessToken((json_decode($requestAccessToken))->access_token);
    }
    
    /**
     * Set acess_token to Client
     *
     * @param string $acess_token
     * @return void
     */
    public function setAccessToken(string $acess_token): void
    {
        $this->config['acess_token'] = $acess_token;
    }

    /**
     * Returns acess_token from Client
     *
     * @return string
     */
    public function getAcessToken(): string
    {
        return $this->config['acess_token'];
    }
    
}
