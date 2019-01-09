<?php
namespace uk\co\neontabs\trello;

/*

    [id] => 560aedd2e6020a83726c319c
    [badges] => stdClass Object
        (
            [votes] => 0
            [viewingMemberVoted] =>
            [subscribed] => 1
            [fogbugz] =>
            [checkItems] => 0
            [checkItemsChecked] => 0
            [comments] => 2
            [attachments] => 0
            [description] =>
            [due] =>
        )

    [checkItemStates] => Array
        (
        )

    [closed] =>
    [dateLastActivity] => 2016-08-08T14:38:44.905Z
    [desc] =>
    [descData] =>
    [due] =>
    [email] =>
    [idBoard] => 560aeda050cf02935cecdc83
    [idChecklists] => Array
        (
        )

    [idLabels] => Array
        (
        )

    [idList] => 560aedb5040189f566416845
    [idMembers] => Array
        (
            [0] => 540db2008db57af9e0c92490
        )

    [idShort] => 1
    [idAttachmentCover] =>
    [manualCoverAttachment] =>
    [labels] => Array
        (
        )

    [name] => Chase Lenny
    [pos] => 65535
    [shortUrl] => https://trello.com/c/UqaUVQx3
    [url] => https://trello.com/c/UqaUVQx3/1-chase-lenny

 */
class Card extends \uk\co\neontabs\Base {

  protected $id = NULL;
  protected $closed = NULL;
  protected $dateLastActivity = NULL;
  protected $desc = NULL;
  protected $descData = NULL;
  protected $due = NULL;
  protected $email = NULL;
  protected $idBoard = NULL;
  protected $idChecklists = array();
  protected $idLabels = array();
  protected $idList = NULL;
  protected $idMembers = array();
  protected $idShort = NULL;
  protected $idAttachmentCover = NULL;
  protected $manualCoverAttachment = NULL;
  protected $labels = array();
  protected $name = NULL;
  protected $pos = NULL;
  protected $shortUrl = NULL;
  protected $url = NULL;
  protected $badges = NULL;
  protected $checkItemStates = array();


}
