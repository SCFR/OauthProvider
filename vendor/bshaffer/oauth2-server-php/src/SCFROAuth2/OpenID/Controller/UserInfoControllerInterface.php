<?php

namespace SCFROAuth2\OpenID\Controller;

use SCFROAuth2\RequestInterface;
use SCFROAuth2\ResponseInterface;

/**
 *  This controller is called when the user claims for OpenID Connect's
 *  UserInfo endpoint should be returned.
 *
 *  ex:
 *  > $response = new SCFROAuth2\Response();
 *  > $userInfoController->handleUserInfoRequest(
 *  >     SCFROAuth2\Request::createFromGlobals(),
 *  >     $response;
 *  > $response->send();
 *
 */
interface UserInfoControllerInterface
{
    public function handleUserInfoRequest(RequestInterface $request, ResponseInterface $response);
}
