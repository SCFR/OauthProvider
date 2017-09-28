<?php

namespace SCFROAuth2\ClientAssertionType;

use SCFROAuth2\RequestInterface;
use SCFROAuth2\ResponseInterface;

/**
 * Interface for all OAuth2 Client Assertion Types
 */
interface ClientAssertionTypeInterface
{
    public function validateRequest(RequestInterface $request, ResponseInterface $response);
    public function getClientId();
}
