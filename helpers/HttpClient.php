<?php 

use GuzzleHttp\Middleware;

class HttpClient implements IHttpClient{

    public $client;
    public $clientHandler;
    public $tapMiddleware;

    public function __construct(){
        $this->client = new GuzzleHttp\Client([
            // Base URI is used with relative requests
            //'base_uri' => 'http://10.80.1.18:8080/MiddlewareCRM/', //Local
            'base_uri' => 'http://10.1.2.103:8080/MiddlewareCRM/',    // Desarrollo
            'scheme' => 'http',
            //'host' => '10.80.1.18',
            'host' => '10.1.2.103',
            'port' => '8080'
        ]);
        $this->clientHandler = $this->client->getConfig('handler');
        // Create a middleware that echoes parts of the request.
        $this->tapMiddleware = Middleware::tap(function ($request) {
            echo $request->getHeaderLine('Content-Type');            
            echo $request->getBody();            
        });
    }

    public function Request($path, $resource, $options){
        $response = $this->client->request($path, $resource, $options);
        return $response;
    }

    public function Get($resource, $queryParams, $data){
        // $response = $this->client->get($resource);
        // var_dump($this->clientHandler);
        // $other = $this->tapMiddleware->call($this, $this->clientHandler);
        $response = $this->client->request('GET', $resource, [
            'query' => $queryParams,
            'json' => $data,
        ]);
        return $response;
    }

    public function Post($resource, $queryParams, $data){
        // $response = $this->client->post($resource , $options);
        $response = $this->client->request('POST', $resource, [
            'query' => $queryParams,
            'json' => $data
        ]);
        return $response;
    }

    public function Put($resource, $queryParams, $data){
        // $response = $this->client->put($resource);
        $response = $this->client->request('PUT', $resource, [
            'query' => $queryParams,
            'json' => $data
        ]);
        return $response;
    }

    public function Delete($resource, $queryParams, $data){
        // $response = $this->client->delete($resource);
        $response = $this->client->request('DELETE', $resource, [
            'query' => $queryParams,
            'json' => $data
        ]);
        return $response;
    }

    public function Options($resource, $queryParams, $data){
        // $response = $this->client->options($resource);
        $response = $this->client->request('OPTIONS', $resource, [
            'query' => $queryParams,
            'json' => $data
        ]);
        return $response;
    }

    public function Head($resource, $queryParams, $data){
        // $response = $this->client->head($resource);
        $response = $this->client->request('HEAD', $resource, [
            'query' => $queryParams,
            'json' => $data
        ]);
        return $response;
    }

    public function Patch($resource, $queryParams, $data){
        // $response = $this->client->patch($resource);
        $response = $this->client->request('PATCH', $resource, [
            'query' => $queryParams,
            'json' => $data
        ]);
        return $response;
    }
}