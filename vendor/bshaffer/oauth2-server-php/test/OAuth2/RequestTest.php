<?php

namespace SCFROAuth2;

use SCFROAuth2\Request\TestRequest;
use SCFROAuth2\Storage\Bootstrap;
use SCFROAuth2\GrantType\AuthorizationCode;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testRequestOverride()
    {
        $request = new TestRequest();
        $server = $this->getTestServer();

        // Smoke test for override request class
        // $server->handleTokenRequest($request, $response = new Response());
        // $this->assertInstanceOf('Response', $response);
        // $server->handleAuthorizeRequest($request, $response = new Response(), true);
        // $this->assertInstanceOf('Response', $response);
        // $response = $server->verifyResourceRequest($request, $response = new Response());
        // $this->assertTrue(is_bool($response));

        /*** make some valid requests ***/

        // Valid Token Request
        $request->setPost(array(
            'grant_type' => 'authorization_code',
            'client_id'  => 'Test Client ID',
            'client_secret' => 'TestSecret',
            'code' => 'testcode',
        ));
        $server->handleTokenRequest($request, $response = new Response());
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertNull($response->getParameter('error'));
        $this->assertNotNUll($response->getParameter('access_token'));
    }

    public function testHeadersReturnsValueByKey()
    {
        $request = new Request(
            array(),
            array(),
            array(),
            array(),
            array(),
            array(),
            array(),
            array('AUTHORIZATION' => 'Basic secret')
        );

        $this->assertEquals('Basic secret', $request->headers('AUTHORIZATION'));
    }

    public function testHeadersReturnsDefaultIfHeaderNotPresent()
    {
        $request = new Request();

        $this->assertEquals('Bearer', $request->headers('AUTHORIZATION', 'Bearer'));
    }

    public function testHeadersIsCaseInsensitive()
    {
        $request = new Request(
            array(),
            array(),
            array(),
            array(),
            array(),
            array(),
            array(),
            array('AUTHORIZATION' => 'Basic secret')
        );

        $this->assertEquals('Basic secret', $request->headers('Authorization'));
    }

    public function testRequestReturnsPostParamIfNoQueryParamAvailable()
    {
        $request = new Request(
            array(),
            array('client_id' => 'correct')
        );

        $this->assertEquals('correct', $request->query('client_id', $request->request('client_id')));
    }

    private function getTestServer($config = array())
    {
        $storage = Bootstrap::getInstance()->getMemoryStorage();
        $server = new Server($storage, $config);

        // Add the two types supported for authorization grant
        $server->addGrantType(new AuthorizationCode($storage));

        return $server;
    }
}
