<?php

namespace MailPoet\Newsletter;

if (!defined('ABSPATH')) exit;


use MailPoet\Models\Subscriber as SubscriberModel;
use MailPoet\Router\Endpoints\ViewInBrowser as ViewInBrowserEndpoint;
use MailPoet\Router\Router;
use MailPoet\Subscribers\LinkTokens;

class Url {
  public static function getViewInBrowserUrl(
    $newsletter,
    $subscriber = false,
    $queue = false,
    bool $preview = true
  ) {
    $linkTokens = new LinkTokens;
    if ($subscriber instanceof SubscriberModel) {
      $subscriber->token = $linkTokens->getToken($subscriber);
    }
    $data = self::createUrlDataObject($newsletter, $subscriber, $queue, $preview);
    return Router::buildRequest(
      ViewInBrowserEndpoint::ENDPOINT,
      ViewInBrowserEndpoint::ACTION_VIEW,
      $data
    );
  }

  public static function createUrlDataObject($newsletter, $subscriber, $queue, $preview) {
    return [
      (!empty($newsletter->id)) ?
        (int)$newsletter->id :
        0,
      (!empty($newsletter->hash)) ?
        $newsletter->hash :
        0,
      (!empty($subscriber->id)) ?
        (int)$subscriber->id :
        0,
      (!empty($subscriber->token)) ?
        $subscriber->token :
        0,
      (!empty($queue->id)) ?
        (int)$queue->id :
        0,
      (int)$preview,
    ];
  }

  public static function transformUrlDataObject($data) {
    reset($data);
    if (!is_int(key($data))) return $data;
    $transformedData = [];
    $transformedData['newsletter_id'] = (!empty($data[0])) ? $data[0] : false;
    $transformedData['newsletter_hash'] = (!empty($data[1])) ? $data[1] : false;
    $transformedData['subscriber_id'] = (!empty($data[2])) ? $data[2] : false;
    $transformedData['subscriber_token'] = (!empty($data[3])) ? $data[3] : false;
    $transformedData['queue_id'] = (!empty($data[4])) ? $data[4] : false;
    $transformedData['preview'] = (!empty($data[5])) ? $data[5] : false;
    return $transformedData;
  }
}
