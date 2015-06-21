<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/../vendor/autoload.php';


$app = new Silex\Application();

$app->get('/get', function (Request $request) use ($app) {

    $token = $request->headers->get('Authorization');
    $name = $request->get('username');
    $status = 403;

    if(empty($token)){
        $json = array('error_code' => 201, 'error_msg' => 'authorization token is invalid');
    }else if(!preg_match('/\A[0-9a-z]+\Z/i', $name)){
        $json = array('error_code' => 101, 'error_msg' => 'username should be alpha-numeric');
    }else{
        $json = array('username' => $name, 'profile' => 'PHPer');
        $status = 200;
    } 
    return $app->json($json, $status);
});

$app->post('/post', function (Request $request) use ($app) {

    $token = $request->headers->get('Authorization');
    $status = 403;

    if(empty($token)){
        $json = array('error_code' => 201, 'error_msg' => 'authorization token is invalid');
    }else{
        $json = array('msg' => 'register succeed');
        $status = 200;
    } 
    return $app->json($json, $status);
});

$app->run();
