<?php namespace scfr\oauth\controller\api;
use \scfr\oauth\api\ApiResponse;

class Identify extends \scfr\oauth\controller\Server {
    
    /**
    * Return the phpbb identity of a token bearer
    *
    * @return SCFRIdentify
    */
    function get_identify() {
        global $db;
        
        // Check we have a token
        if($this->ensure_authorized()) {
            // Get the user id from the token
            $user_id = $this->token_user_id();
            
            // Fetch the data
            $sql = 'SELECT username, user_colour
            FROM ' . USERS_TABLE . '
            WHERE user_id = ' . $db->sql_escape($user_id);
            
            $result = $db->sql_query($sql);
            $row = $db->sql_fetchrow($result);
            $db->sql_freeresult($result);
            
            // If we have data hydrate the payload
            if($row){
                
                
                
                $payload = [
                    "username" => $row['username'],
                    "user_color" => $row['user_colour'] ? "#".$row['user_colour'] : null,
                    "user_id" => (integer) ($row['user_id']),
                    "org" => $this->getOrgOfPlayerById($user_id)
                ];
                
                return \scfr\oauth\api\ApiResponse::success($payload);
            }
        }
    }
    
    private function getOrgOfPlayerById($user_id) {
        global $db;
        
        // Fetch the data
        $sql = 'SELECT pf_guild_public, pf_guild
        FROM testfo_profile_fields_data WHERE user_id = ' . $db->sql_escape($user_id);
        
        $result = $db->sql_query($sql);
        $row = $db->sql_fetchrow($result);
        $db->sql_freeresult($result);

        if($row && $row['pf_guild_public']) return $row['pf_guild'];
        else return "";
    }
    
}