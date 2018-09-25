<?php
namespace Models;
use \Lcobucci\JWT\Builder;
use \Lcobucci\JWT\ValidationData;
use \Lcobucci\JWT\Parser;
use \Models\Estudiante;
use \Models\Gestion;
class Utils
{
    /**
     * Generates a token based in a id and email of user.
     */
    public static function generateToken($id, $correo) {
        $currentTime = time();
        $tokenstr = (new Builder())
            ->setIssuer(IP)
            ->setIssuedAt($currentTime)
            ->setExpiration($currentTime + 90 * 60)
            ->set('id', $id)
            ->set('correo', $correo)
            ->getToken();                    
        return (string) $tokenstr;
    }
    public static function decodeToken($tokenstr) {
        $token = (new Parser())->parse((string)$tokenstr);
        $data = new ValidationData();
        $data->setIssuer(IP);
        if (!$token->isExpired()) {
            return [
                'id' => $token->getClaim('id'),
                'correo' => $token->getClaim('correo')
            ];
        }
        return false;            
    }
    public static function validateData($data, $fields)
    {
        foreach ($fields as $value) {
            if (! isset($data[$value])) {
                return false;
            }
        }
        return true;
    }
    public static function implodeFields($fields) {
        return 'No se reconocen uno o varios de los campos: '. implode(', ', $fields);
    }
}
