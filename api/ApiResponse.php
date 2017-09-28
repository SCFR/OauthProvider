<?php namespace scfr\oauth\api;

use Symfony\Component\Config\Definition\Exception\Exception;
use \Symfony\Component\HttpFoundation\JsonResponse as JsonResponse;

class ApiResponse extends JsonResponse {
    /**
     * @param $success
     * @return JsonResponse
     */
    static function success($success){
        $reponse = array(
            'data' => $success,
            'err' => false,
            'msg' => null
        );
        return new JsonResponse($reponse);
    }

    /**
     * @param Exception $exception
     * @return JsonResponse
     */
    static function error(Exception $exception){
        $reponse = array(
            'data' => null,
            'err' => true,
            'msg' => $exception->getMessage()
        );
        return new JsonResponse($reponse);
    }
}