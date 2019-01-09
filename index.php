<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/autoload.php';

use \Trello\Trello;
use uk\co\neontabs\trellojira\Issue;
use uk\co\neontabs\trellojira\Jira;

form();

function runImport() {
  $consumer_key = '';
  $token = '';
  $board_id = '';

  /** @var Trello $trello */
  $trello = new Trello($consumer_key, null, $token);

  $cards = $trello->get('boards/' . $board_id  . '/cards');
  $lists = $trello->get('boards/' . $board_id  . '/lists');

  $lists_to_status = [
    '' => '', // Backlog
//    '' => '', // To Do
//    '' => '', // Doing
  ];

  $due_date = new DateTime();
  $due_date = $due_date->format('Y-m-t');

  $file = 'issues.txt';
  $current = file_get_contents($file);
  $current = json_decode($current, TRUE);


  foreach ($cards as $id => $card) {
    $id = $card->id;
    if (!isset($lists_to_status[$card->idList])) {
      continue;
    }

    $actions = $trello->get('cards/' . $id  . '/actions');

    $comments = [];
    foreach ($actions as $action) {
      if ($action->type == 'commentCard') {
        $comment = $trello->get('actions/' . $action->id);
        $comments[] = [
          $comment->display->entities->memberCreator->text,
          $comment->display->entities->comment->text,
        ];
      }
    }


    $data = [];
    $data['duedate'] = $due_date;
    $data['description'] = $card->desc;
    //      $data['resolution'] = $card->desc;
    $data['assignee'] = [
      'name' => '',
    ];
    $data['reporter'] = [
      'name' => '',
    ];
    $data['priority'] = [
      'id' => '',
    ];

    if (!empty($comments)) {
      $data['description'] .= "
      
      ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
      
      Комментарии:";
      foreach ($comments as $comment) {
        $data['description'] .= "
        " . $comment[0] . ': ' . $comment[1];

        $data['description'] .= "
      ______________________________";
      }
    }

    if (!empty($current[$id])) {
      $params['fields'] = $data;
      Issue::editIssue($current[$id], $params);
    }
    else {
      $issue = Issue::createNewIssue($card->name, Jira::getProperty('project'), $data);
      $current[$id] = $issue['id'];
    }
  }

  // Пишем содержимое обратно в файл
  file_put_contents($file, json_encode($current));
}

function form() {
  echo '<form action="/" method="post" id="devel-execute-form" accept-charset="UTF-8">
<input type="submit" id="edit-op" name="op" value="runImport">
</form>';


  if (isset($_POST['op']) && ($_POST['op'] == 'runImport')) {
    runImport();
  }
}