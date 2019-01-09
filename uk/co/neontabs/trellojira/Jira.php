<?php

namespace uk\co\neontabs\trellojira;

use chobie\Jira\Api;
use chobie\Jira\Api\Authentication\Anonymous;

class Jira {

  static protected $api = FALSE;

  public static function getApiInstance() {
    if (!self::$api) {
      $url = self::getProperty('jira_url');
      //      $name = self::getProperty('jira_name');
      //      $pass = self::getProperty('jirs_pass');
      $auth = new Anonymous();
      $client = new CurlClient();
      self::$api = new Api($url, $auth, $client);
    }

    return self::$api;
  }

  public static function getProperty($key) {
    $vars = [
      'project' => '',
      'jira_url' => '',
      'jira_name' => '',
      'jirs_pass' => '',
    ];

    if (isset($vars[$key])) {
      return $vars[$key];
    }

    return FALSE;
  }

  public static function getSessionId() {
    $ch = curl_init(self::getProperty('jira_url') . '/rest/auth/1/session');
    $jsonData = [
      'username' => self::getProperty('jira_name'),
      'password' => self::getProperty('jirs_pass'),
    ];
    $jsonDataEncoded = json_encode($jsonData);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $result = curl_exec($ch);
    curl_close($ch);
    $sess_arr = json_decode($result, TRUE);

    if (!isset($sess_arr['errorMessages'][0])) {
      return $sess_arr['session']['value'];
    }

  }

}
