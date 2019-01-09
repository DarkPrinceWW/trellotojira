<?php

namespace uk\co\neontabs\trellojira;

use chobie\Jira\Issues\Walker;

class Issue {

  public static function getIssue($issue_id) {
    $api = Jira::getApiInstance();
    $walker = new Walker($api);
    $walker->push(
      'issuekey = ' . $issue_id
    );

    foreach ($walker as $issue) {
      return $issue;
    }
  }

  public static function parseTitle($title) {
    $matches = array();
    $count = preg_match('/[a-zA-Z]{2}-\d+$/', $title, $matches);

    if ($count) {
      return $matches[0];
    }
    else {
      return FALSE;
    }
  }

  public static function createNewIssue($title, $project, $data) {
    $api = Jira::getApiInstance();
    $response = $api->createIssue($project, $title, "3", $data);

    $result = $response->getResult();
    if (array_key_exists('errorMessages', $result)) {
      var_dump($response);
      return FALSE;
    }
    else {
      return $result;
    }
  }

  public static function editIssue($issue_id, $data) {
    $api = Jira::getApiInstance();
    $response = $api->editIssue($issue_id, $data);

    if ($response) {
      $result = $response->getResult();
      if (array_key_exists('errorMessages', $result)) {
        var_dump($response);
        return FALSE;
      }
      else {
        return $result;
      }
    }
    return FALSE;
  }

}
