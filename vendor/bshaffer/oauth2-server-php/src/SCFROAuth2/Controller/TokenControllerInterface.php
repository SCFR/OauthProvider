<?php

namespace SCFROAuth2\Controller;

use SCFROAuth2\RequestInterface;
use SCFROAuth2\ResponseInterface;

/**
 *  This controller is called when a token is being requested.
 *  it is called to handle all grant types the application supports.
 *  It also validates the client's credentials
 *
 *  ex:
 *  > $tokenController->handleTokenRequest(SCFROAuth2\Request::createFromGlobals(), $response = new SCFROAuth2\Response());
 *  > $response->send();
 *
 */
interface TokenControllerInterface
{
    /**
     * handleTokenRequest
     *
     * @param $request
     * SCFROAuth2\RequestInterface - The current http request
     * @param $response
     * SCFROAuth2\ResponseInterface - An instance of SCFROAuth2\ResponseInterface to contain the response data
     *
     */
    public function handleTokenRequest(RequestInterface $request, ResponseInterface $response);

    public function grantAccessToken(RequestInterface $request, ResponseInterface $response);
}
