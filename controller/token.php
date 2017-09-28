<?php namespace scfr\oauth\controller;
use \scfr\oauth\api\ApiResponse;

class Token extends Server {
    /**
     * Called on api endpoint to generate tokens
     * @return void
     */
    public function handle() {
        global $request;
        $this->server->handleTokenRequest(\OAuth2\Request::createFromGlobals())->send();
        die();
    }
}
?>