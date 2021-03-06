<?php

/**
 * Class FacebookMessageReceive
 */
class FacebookMessageReceive {

	/**
	 * @var object
	 */
	private $message;

	/**
	 * FacebookMessageReceive constructor.
	 */
	public function __construct() {
		$this->message = json_decode(file_get_contents('php://input'));
	}

	public function getMessage() {
		return $this->message;
	}

	/**
	 * Get entry object
	 * @return mixed
	 */
	public function getEntry() {
		if ( $this->message ) {
			if ( isset( $this->message->entry ) && is_array( $this->message->entry ) ) {
				$entry = $this->message->entry[0];

				return $entry;
			}

			return false;
		}

		return false;
	}

	/**
	 * Get User ID
	 * @return mixed False if cant get or User ID (int)
	 */
	public function getID() {
		$entry = $this->getEntry();
		if ( $entry && is_object( $entry ) ) {
			if ( isset( $entry->id) ) {
				return $entry->id;
			}
			return false;
		}

		return false;
	}


	/**
	 * Get send time
	 * @return bool|\DateTime
	 */
	public function getTime() {
		$entry = $this->getEntry();
		if ( $entry && is_object( $entry ) ) {
			if ( isset( $entry->time) && is_int($entry->time)) {
				return new \DateTime( $entry->time );
			} elseif(isset($this->message->timestamp)) {
				return new \DateTime($this->message->timestamp);
			}

			return false;
		}

		return false;
	}

	/**
	 * Get message object
	 * @return bool|object
	 */
	public function getMessaging() {
		$entry = $this->getEntry();
		if ( $entry && is_object( $entry ) ) {
			if ( isset( $entry->messaging[0] ) && is_object( $entry->messaging[0] ) ) {
				return $entry->messaging[0];
			}

			return false;
		} elseif(isset($this->message->message)) {
			return $this->message->message;
		}

		return false;
	}

	/**
	 * Get Sender ID
	 * @return bool|object False if cant get sender, INT if has sender id
	 */
	public function getSender() {
		if($this->getMessaging()) {
			$messaging = $this->getMessaging();
			if(isset($messaging->sender->id)) {
				return $messaging->sender->id;
			}
			return false;
		}
		return false;
	}

	/**
	 * @return bool|object
	 */
	public function getRecipient() {
		if($this->getMessaging()) {
			$messaging = $this->getMessaging();
			if(isset($messaging->recipient->id)) {
				return $messaging->recipient->id;
			}
			return false;
		}
		return false;
	}

	/**
	 * @return bool|object
	 */
	public function getDelivery() {
		if($this->getMessaging()) {
			$messaging = $this->getMessaging();
			if(isset($messaging->delivery) && is_object($messaging->delivery)) {
				return $messaging->delivery;
			}
			return false;
		}
		return false;
	}

	public function getMessagingMessage() {
		if($this->getMessaging()) {
			$messaging = $this->getMessaging();
			if(isset($messaging->message)) {
				return $messaging->message;
			}
		}
		return false;
	}


	/**
	 * @return bool|array
	 */
	public function getDeliveryMids() {
		if($this->getDelivery()) {
			$delivery = $this->getDelivery();
			if(isset($delivery->mids) && is_array($delivery->mids)) {
				return $delivery->mids;
			}
			return false;
		}
		return false;
	}

	/**
	 * @return bool|int
	 */
	public function getDeliveryWatermark() {
		if($this->getDelivery()) {
			$delivery = $this->getDelivery();
			if(isset($delivery->watermark)) {
				return $delivery->watermark;
			}
			return false;
		}
		return false;
	}


	/**
	 * @return bool|int
	 */
	public function getDeliverySEQ() {
		if($this->getDelivery()) {
			$delivery = $this->getDelivery();
			if(isset($delivery->seq)) {
				return $delivery->seq;
			}
			return false;
		}
		return false;
	}

	public function getMessagingPostback() {
		return isset($this->getMessaging()->postback) ? $this->getMessaging()->postback:false;
	}

	public function getMessagingPostbackPayload() {
		return isset($this->getMessagingPostback()->payload)?$this->getMessagingPostback()->payload:false;
	}
}
