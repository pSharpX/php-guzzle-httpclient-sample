<?php
interface IAsyncHttpClient{
    public function RequestAsync($path, $resource, $options);
    public function GetAsync($resource, $queryParams, $data);
    public function PostAsync($resource, $queryParams, $data);
    public function PutAsync($resource, $queryParams, $data);
    public function DeleteAsync($resource, $queryParams, $data);
    public function OptionsAsync($resource, $queryParams, $data);
    public function HeadAsync($resource, $queryParams, $data);
    public function PatchAsync($resource, $queryParams, $data);
}