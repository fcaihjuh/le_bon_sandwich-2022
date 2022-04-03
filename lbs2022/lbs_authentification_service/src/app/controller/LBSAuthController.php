<?php

namespace lbs\auth\app\controller;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use lbs\auth\app\models\User;
// use lbs\auth\api\utils\Writer;
use lbs\auth\app\error\JsonError;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


/**
 * Class LBSAuthController
 * @package lbs\command\api\controller
 */
class LBSAuthController /*extends Controller*/
{

    private $container;

    public function __constrcut(\Slim\Container $container){
        $this->container = $container;
    }


    public function authenticate(Request $rq, Response $rs, $args): Response {

        if (!$rq->hasHeader('Authorization')) {

            $rs = $rs->withHeader('WWW-authenticate', 'Basic realm="commande_api api" ');
            return JsonError::jsonError($rq, $rs, 'error', 401, 'No Authorization header present');
        };

        $authstring = base64_decode(explode(" ", $rq->getHeader('Authorization')[0])[1]);
        list($email, $pass) = explode(':', $authstring);

        try {
            $user = User::select('id', 'email', 'username', 'passwd', 'refresh_token', 'level')
                ->where('email', '=', $email)
                ->firstOrFail();

            if (!password_verify($pass, $user->passwd))
                throw new \Exception("password check failed");

            unset ($user->passwd);

        } catch (ModelNotFoundException $e) {
            $rs = $rs->withHeader('WWW-authenticate', 'Basic realm="lbs auth" ');
            return JsonError::jsonError($rq, $rs, 'error', 401, 'Erreur authentification');
        } catch (\Exception $e) {
            $rs = $rs->withHeader('WWW-authenticate', 'Basic realm="lbs auth" ');
            return JsonError::jsonError($rq, $rs, 'error', 401, 'Erreur authentification');
        }


        $secret = $this->container->settings['secret'];
        $token = JWT::encode(['iss' => 'http://api.auth.local/auth',
            'aud' => 'http://api.backoffice.local',
            'iat' => time(),
            'exp' => time() + (12 * 30 * 24 * 3600),
            'upr' => [
                'email' => $user->email,
                'username' => $user->username,
                'level' => $user->level
            ]],
            $secret, 'HS512');

        $user->refresh_token = bin2hex(random_bytes(32));
        $user->save();
        $data = [
            'access-token' => $token,
            'refresh-token' => $user->refresh_token
        ];

        return JsonError::json_output($rs, 200, $data);


    }

    public function check(Request $req, Response $resp, array $args): Response {

        try{

            $secret = $this->container->settings['secret'];

            $auth = $req->getHeader('Authorization')[0];
            $token_string = sscanf($auth, "Bearer %s")[0];
            $token = JWT::decode($token_string, new Key($secret, 'HS512'));

            $data = [
                'user-mail' => $token->upr->email,
                'user-username' => $token->upr->username,
                'user-level' => $token->upr->level,
            ];

            return JsonError::json_output($resp, 200, $data);
        }
        catch(ExpiredException $e){
            return JsonError::jsonError($req, $resp, 'error', 401, 'The token is expired');
        }
        catch (SignatureInvalidException $e){
            return JsonError::jsonError($req, $resp, 'error', 401, 'The signature is not valid');
        }
        catch (BeforeValidException $e){
            return JsonError::jsonError($req, $resp, 'error', 401, 'BeforeValidException');
        }
        catch (\UnexpectedValueException $e){
            return JsonError::jsonError($req, $resp, 'error', 401, 'The value of token is not the right one');
        }

        return $resp;
    }

}