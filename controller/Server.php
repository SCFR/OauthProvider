<?php namespace scfr\oauth\controller;

class Server {
    /** contains our oauth storage
    * @var \OAuth2\Storage\Pdo
    */
    protected $_storage;

    /**
     * The main server instance
     *
     * @var \OAuth2\Server
     */
    protected $server;
    
    /**
     * Does the main oauth server init steps
     */
    public function __construct() {
        global $request;
        
        require_once(__DIR__ . "/../config/config.conf.php");

        $dsn      = $SCFR_OAUTH_CONF['dsn'];
        $username = $SCFR_OAUTH_CONF['username'];
        $password = $SCFR_OAUTH_CONF['password'];
        $request->enable_super_globals();
        
        \OAuth2\Autoloader::register();
        // Create the storage method for this server
        $this->_storage = new \OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));

        // Create the server
        $this->server = new \OAuth2\Server($this->_storage);

        // Add the "Client Credentials" grant type (it is the simplest of the grant types)
        $this->server->addGrantType(new \OAuth2\GrantType\ClientCredentials($this->_storage));
        // Add the "Authorization Code" grant type (this is where the oauth magic happens)
        $this->server->addGrantType(new \OAuth2\GrantType\AuthorizationCode($this->_storage));
        // Support refresh tokens
        $this->server->addGrantType(new \OAuth2\GrantType\RefreshToken($this->_storage), array(
            'always_issue_new_refresh_token' => true
        ));
    }

    /**
     * Check if the current request is the bearer of a token
     *
     * @param string $scope the scope to check against
     * @return boolean true if authorized for given scope, dies otherwise.
     */
    protected function ensure_authorized($scope = "basic") {
        if (!$this->server->verifyResourceRequest(\OAuth2\Request::createFromGlobals(), null, $scope)) {
            $this->server->getResponse()->send();
            die;
        }

        return true;
    }

    /**
     * Check if we have an active authed phpbb session
     * @return boolean
     */
    protected function is_authed() {
        global $user;
        return $user->data['user_id'] > 1;
    }

    /**
     * Extracts the user_id from an oauth token
     * @return integer
     */
    protected function token_user_id() {
        return (integer) $this->get_request_token()['user_id'];
    }

    /**
     * Extracts a token from a valid request 
     * @return mixed
     */
    protected function get_request_token() {
        return $this->server->getAccessTokenData(\OAuth2\Request::createFromGlobals());
    }

}
?>