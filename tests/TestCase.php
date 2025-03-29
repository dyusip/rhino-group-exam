<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected string $apiPrefix = '/v1';

    protected function getJsonWithPrefix(string $uri, array $headers = [])
    {
        return $this->getJson($this->apiPrefix . $uri, $headers);
    }

    protected function postJsonWithPrefix(string $uri, array $data = [], array $headers = [])
    {
        return $this->postJson($this->apiPrefix . $uri, $data, $headers);
    }

    protected function putJsonWithPrefix(string $uri, array $data = [], array $headers = [])
    {
        return $this->putJson($this->apiPrefix . $uri, $data, $headers);
    }

    protected function deleteJsonWithPrefix(string $uri, array $headers = [])
    {
        return $this->deleteJson($this->apiPrefix . $uri, $headers);
    }
}
