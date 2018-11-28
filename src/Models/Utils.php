<?php
namespace Models;

use \Lcobucci\JWT\Builder;
use \Lcobucci\JWT\Parser;
use \Lcobucci\JWT\ValidationData;
use \Models\Carrera;
use \Slim\Http\UploadedFile;

class Utils
{
    /**
     * Generates a token based in a id and email of user.
     */
    public static function generateToken($id, $correo)
    {
        $currentTime = time();
        $tokenstr = (new Builder())
            ->setIssuer(IP)
            ->setIssuedAt($currentTime)
            ->setExpiration($currentTime + 3600)
            ->set('id', $id)
            ->set('correo', $correo)
            ->getToken();
        return (string) $tokenstr;
    }
    public static function decodeToken($tokenstr)
    {
        $token = (new Parser())->parse((string) $tokenstr);
        $data = new ValidationData();
        $data->setIssuer(IP);
        if (!$token->isExpired()) {
            return [
                'id' => $token->getClaim('id'),
                'correo' => $token->getClaim('correo'),
            ];
        }
        return false;
    }
    public static function getCarrer()
    {
        return Carrera::first();
    }
    public static function getCarrerWithProtocol()
    {
        $carrera = Carrera::first();
        $carrera->urlLogo = self::withProtocol($carrera->urlLogo);
        return $carrera;
    }
    public static function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
    public static function validateData($data, $fields)
    {
        foreach ($fields as $value) {
            if (!isset($data[$value])) {
                return false;
            }
        }
        return true;
    }
    public static function implodeFields($fields)
    {
        return 'No se reconocen uno o varios de los campos: ' . implode(', ', $fields);
    }
    public static function withProtocol($url)
    {
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
        return $protocol . $url;
    }
}
