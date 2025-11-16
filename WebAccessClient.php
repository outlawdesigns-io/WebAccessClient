<?php

class WebAccessClient{

  const HOSTEND = 'host/';
  const REQEND = 'request/';

  protected $_serviceUrl;
  protected $_accessToken;

  public function __construct($apiUrl,$accessToken){
    if($apiUrl[strlen($apiUrl) - 1] != '/') $apiUrl .= '/';
    $this->_serviceUrl = $apiUrl;
    $this->_accessToken = $accessToken;
  }
  public function apiGet($uri){
    $headers = array('Authorization: Bearer ' . $this->_accessToken);
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$this->_serviceUrl . $uri);
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
    return $this->apiGet(self::HOSTEND . $id);
  }
  public function getRequest($id = null){
    return $this->apiGet(self::REQEND . $id);
  }
  public function getDailyRequests($date = null){
    return $this->apiGet(self::REQEND . 'daily/' . $date);
  }
  public function getDocTypeCounts($extension){
    return $this->apiGet(self::REQEND . 'extension/' . $extension);
  }
  public function search($endpoint,$key,$value){
    return $this->apiGet($endpoint . "/search/" . $key . "/" . $value);
  }
}
