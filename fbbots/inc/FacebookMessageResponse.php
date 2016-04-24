<?php
/**
 * Class FacebookMessageResponse
 * @package Model
 */
class FacebookMessageResponse {

	/**
	 * @var Curl
	 */
	private $curl;
	/**
	 * @var array
	 */
	private $page_access_token;
	/**
	 * @var FacebookMessageReceive
	 */
	private $received;
	/**
	 * @var array
	 */
	private $response;

	/**
	 * FacebookMessageResponse constructor.
	 *
	 * @param string|FacebookMessageReceive $receive
	 */
	public function __construct( $receive = '' ) {
		if ( ! $receive ) {
			$this->received = new FacebookMessageReceive();
		} else {
			$this->received = $receive;
		}
		$this->response = array(
			'recipient' => array(
				"id" => $this->received->getSender()
			),
			'message'   => array(
				'text' => ''
			)
		);
		$this->curl     = new Curl();
		$this->curl->setHeader( 'Content-Type', 'application/json' );
		global $bot_config;
		$this->page_access_token = $bot_config['page_access_token'];
	}


	/**
	 * @param string $type Type can be REGULAR, SILENT_PUSH or NO_PUSH
	 */
	public function setNotificationType($type = 'REGULAR') {
		$this->response['notification_type'] = $type;
	}

	public function getFacebookMessageReceived() {
		return $this->received;
	}

	/**
	 * Choose userid to send message, if is null, userid = last userid that send message
	 *
	 * @param string $userid
	 */
	public function sendTo( $userid = '' ) {
		if ( $userid ) {
			$this->response['recipient'] = array(
				"id" => $userid
			);
		} else {
			if ( $this->received->getSender() ) {
				$sender                      = $this->received->getSender();
				$this->response['recipient'] = array(
					"id" => $sender
				);
			}
		}
	}

	/**
	 * Content to send
	 *
	 * @param $text string
	 * @param $sendnow bool
	 */
	public function text( $text, $sendnow = true ) {
		if ( is_string( $text ) ) {
			$this->response['message']['text'] = $text;
		}
		if($sendnow) $this->send();
	}

	public function image( $imageUrl, $sendnow = true ) {
		if ( is_string( $imageUrl ) ) {
			$this->response['message']['attachment'] = array(
				'type'    => 'image',
				'payload' => array(
					'url' => $imageUrl
				)
			);
		}
		if($sendnow) $this->send();
	}

	public function button($content, $sendnow = true) {
		$response = array(
			"attachment" => array(
				"type" => "template",
				"payload" => array(
					"template_type" => "button",
					"text" => $content['text'],
					"buttons" => $content['buttons']
				)
			)
		);
		$this->response['message'] = $response;
		if($sendnow) $this->send();
	}

	public function generic($elements, $sendnow = true) {
		$response = array(
			"attachment" => array(
				"type" => "template",
				"payload" => array(
					"template_type" => "generic",
					"elements" => $elements
				)
			)
		);
		$this->response['message'] = $response;
		if($sendnow) $this->send();
	}

	public function receipt($content, $sendnow = true) {
		$timestamp = empty($content['timestampt'])?time():$content['timestampt'];
		$response = array(
			"attachment" => array(
				"type" => "template",
				"payload" => array(
					"template_type" => "receipt",
					"recipient_name" => $content['name'],
					"order_number" => $content['order_number'],
					"currency" => $content['currency'],
					"payment_method" => $content['payment_method'],
					"order_url" => $content['order_url'],
					"timestamp" => $timestamp,
					"elements" => $content['elements'],
					"address" => $content['address'],
					"summary" => $content['summary'],
					"adjustments" => $content['adjustments']
				)
			)
		);
		$this->response['message'] = $response;
		if($sendnow) $this->send();
	}

	/**
	 * Send message to facebook now
	 */
	public function send() {
		$this->curl->post( "https://graph.facebook.com/v2.6/me/messages?access_token={$this->page_access_token}",
			$this->response );
	}
}
