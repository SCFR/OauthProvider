<?php

namespace SCFROAuth2\GrantType;

use SCFROAuth2\ResponseType\AccessTokenInterface;
use SCFROAuth2\RequestInterface;
use SCFROAuth2\ResponseInterface;

/**
 * Interface for all OAuth2 Grant Types
 */
interface GrantTypeInterface
{
    public function getQuerystringIdentifier();
    public function validateRequest(RequestInterface $request, ResponseInterface $response);
    public function getClientId();
    public function getUserId();
    public function getScope();
    public function createAccessToken(AccessTokenInterface $accessToken, $client_id, $user_id, $scope);
}
