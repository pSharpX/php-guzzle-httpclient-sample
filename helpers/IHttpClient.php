<?php
interface IHttpClient{
    public function Request($path, $resource, $options);
    public function Get($resource, $queryParams, $data);
    public function Post($resource, $queryParams, $data);
    public function Put($resource, $queryParams, $data);
    public function Delete($resource, $queryParams, $data);
    public function Options($resource, $queryParams, $data);
    public function Head($resource, $queryParams, $data);
    public function Patch($resource, $queryParams, $data);
}