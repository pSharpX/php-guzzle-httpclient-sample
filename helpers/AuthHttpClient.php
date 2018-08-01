<?php

use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Middleware;

class AuthHttpClient implements IHttpClient{
    
    private $authHttpclient;
    private $clientHandler;
    private $tapMiddleware;

    private $credentials = array(
        'grant_type' => 'password',
		'client_id' => 'optical-client-id',
		'client_secret' => 'optical',
		'username' => 'optical',
		'password' => 'password'
    );

    private $accessToken = array(
        'grant_type' => 'refresh_token',
		'client_id' => 'optical-client-id',
		'refresh_token' => '',
		'client_secret' => 'optical'
    );

    private $httpClient;    
    
    public function __construct($httpClient){
        $this->authHttpClient = $this->client = new GuzzleHttp\Client([
            // Base URI is used with relative requests            
            //'base_uri' => 'http://10.80.1.18:8080/MiddlewareCRM/oauth/', //Local
            'base_uri' => 'http://10.1.2.103:8080/MiddlewareCRM/oauth/',    // Desarrollo
            'scheme' => 'http',
            //'host' => '10.80.1.18',
            'host' => '10.1.2.103',
            'port' => '8080',
        ]);
        $this->clientHandler = $this->client->getConfig('handler');
        // Create a middleware that echoes parts of the request.
        $this->tapMiddleware = Middleware::tap(function ($request) {
            echo $request->getHeaderLine('Content-Type');
            echo $request->getBody();
        });

        $this->httpClient = new HttpClient();
    }

    public function Request($path, $resource, $options){
        return $this->httpClient->Request($path, $resource, $options);
    }

    public function Get($resource, $queryParams, $data){
        $credentials = $this->credentials;
        $accessToken = $this->accessToken;        
        $promise = new Promise(function () use (&$promise, $credentials, $accessToken) {            
            $response = $this->refreshToken($credentials);
            if($response->getStatusCode() !== 200){

            }
            $bodyResponse = $response->getBody();
            $refreshToken = json_decode($bodyResponse)->refresh_token;

            $accessToken['refresh_token'] = $refreshToken;
            $response = $this->accessToken($accessToken);
            if($response->getStatusCode() !== 200){

            }
            $bodyResponse = $response->getBody();
            $promise->resolve(json_decode($bodyResponse));
        });

        $otherPromise = $promise
            ->then(function ($accessToken) use($resource, $queryParams, $data) {
                $queryParams['access_token'] = $accessToken->access_token;
                $response = $this->httpClient->Get($resource, $queryParams, $data);
                $json = json_decode($response->getBody());                
                return $response;
            });
        $promise->wait();
        return $otherPromise->wait();
    }

    public function Post($resource, $queryParams, $data){
        $credentials = $this->credentials;
        $accessToken = $this->accessToken;        
        $promise = new Promise(function () use (&$promise, $credentials, $accessToken) {            
            $response = $this->refreshToken($credentials);
            if($response->getStatusCode() !== 200){

            }
            $bodyResponse = $response->getBody();
            $refreshToken = json_decode($bodyResponse)->refresh_token;

            $accessToken['refresh_token'] = $refreshToken;
            $response = $this->accessToken($accessToken);
            if($response->getStatusCode() !== 200){

            }
            $bodyResponse = $response->getBody();
            $promise->resolve(json_decode($bodyResponse));
        });

        $otherPromise = $promise
            ->then(function ($accessToken) use($resource, $queryParams, $data) {
                $queryParams['access_token'] = $accessToken->access_token;
                $response = $this->httpClient->Post($resource, $queryParams, $data);
                $json = json_decode($response->getBody());                
                return $response;
            });
        $promise->wait();        
        return $otherPromise->wait();
    }

    public function Put($resource, $queryParams, $data){
        return $this->httpClient->Put($resource, $queryParams, $data);
    }

    public function Delete($resource, $queryParams, $data){
        return $this->httpClient->Delete($resource, $queryParams, $data);
    }

    public function Options($resource, $queryParams, $data){
        return $this->httpClient->Options($resource, $queryParams, $data);
    }

    public function Head($resource, $queryParams, $data){
        return $this->httpClient->Head($resource, $queryParams, $data);
    }

    public function Patch($resource, $queryParams, $data){
        return $this->httpClient->Patch($resource, $queryParams, $data);
    }

    private function refreshToken($params){        
        return $this->authHttpClient->request('GET', 'token', [
            'query' => $params
        ]);
    }

    private function accessToken($params){        
        return $this->authHttpClient->request('GET', 'token', [
            'query' => $params
        ]);        
    }
}