<?php namespace scfr\oauth\controller;
use \scfr\oauth\api\ApiResponse;

class Authorize extends Server
{
    /** @var \phpbb\controller\helper */
    protected $helper;
    
    /** phpbbtpl
    * @var \phpbb\template\template
    */
    protected $template;
    
    public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template) {
        parent::__construct();
        $this->helper   = $helper;
        $this->template = $template;
    }
    
    /**
     * Called on api end-point
     * Will perform the authorization oauth logic
     * @return void
     */
    public function handle() {
        $rq = \SCFROAuth2\Request::createFromGlobals();
        $response = new \SCFROAuth2\Response();
        
        // Validate we have all we need in the auth request
        if (!$this->server->validateAuthorizeRequest($rq, $response)) {
            $response->send();
            die;
        }
        
        // If the user has already authorized the app, proceed
        $is_authorized = (isset($_POST['authorized']));
        if($is_authorized) {
            $this->server->handleAuthorizeRequest($rq, $response, $is_authorized, $this->get_user_id());
            $response->send();
        }
        
        // The user has no authorized the app, we build a form for him to do so.
        $this->template->assign_vars(array(
            'USER_IS_LOGGED_IN' => $this->is_authed(),
            'DISPLAY_FORM' => !$_POST,
            'USERNAME' => $this->get_user_name(),
            'USER_COLOR' =>  $this->get_user_color(),
            'OAUTH_APP_NAME' => "Jade",
        ));
        
        $this->template->assign_block_vars("scope", ["name" => "Accéder à tes informations publiques StarCitizen.fr"]);
        
        return $this->helper->render('authorize_body.html');
    }

    /**
     * Get the current user color
     * @return string
     */
    private function get_user_color() {
        global $user;

        return $user->data['user_colour'] ? "#".$user->data['user_colour'] : "#51C3FA";
    }
    /**
     * Get the current user name
     * @return string
     */
    private function get_user_name() {
        global $user;
        return $user->data['username'];
    }

    /**
     * Get the current user id
     * @return integer
     */
    private function get_user_id() {
        global $user;

        return (integer) $user->data['user_id'];
    }
}
?>