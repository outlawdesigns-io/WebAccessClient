<?php

class WebAccessClient{

  const APIEND = 'http://api.outlawdesigns.io:9500/';
  const HOSTEND = 'host/';
  const REQEND = 'request/';

  protected $_auth_token;

  public function __construct($auth_token){
    $this->_auth_token = $auth_token;
  }
  public function apiGet($uri){
    $headers = array('auth_token: ' . $this->_auth_token);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,self::APIEND . $uri);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    $output = json_decode(curl_exec($ch));
    curl_close($ch);
    if(isset($output->error)){
      throw new \Exception($output->error);
    }
    return $output;
  }
  public function getHost($id = null){
    try{
      return $this->apiGet(self::HOSTEND . $id);
    }catch(\Exception $e){
      throw new \Exception($e->getMessage());
    }
  }
  public function getRequest($id = null){
    try{
      return $this->apiGet(self::REQEND . $id);
    }catch(\Exception $e){
      throw new \Exception($e->getMessage());
    }
  }
  public function getDailyRequests($date = null){
    try{
      return $this->apiGet(self::REQEND . 'daily/' . $date);
    }catch(\Exception $e){
      throw new \Exception($e->getMessage());
    }
  }
  public function getLoeSongCounts(){
    try{
      return $this->apiGet(self::REQEND . 'songs');
    }catch(\Exception $e){
      throw new \Exception($e->getMessage());
    }
  }
  public function search($endpoint,$key,$value){
    try{
      return $this->apiGet($endpoint . "/search/" . $key . "/" . $value);
    }catch(\Exception $e){
      throw new \Exception($e->getMessage());
    }
  }
  public static function authenticate($username,$password){
    $headers = array('request_token: ' . $username,'password: ' . $password);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,self::APIEND . "authenticate");
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    $output = json_decode(curl_exec($ch));
    curl_close($ch);
    if(isset($output->error)){
      throw new \Exception($output->error);
    }
    return $output;
  }
  public static function verifyToken($token){
    $obj = new self($token);
    try{
      return $obj->apiGet('verify');
    }catch(\Exception $e){
      throw new \Exception($e->getMessage());
    }
  }
}
