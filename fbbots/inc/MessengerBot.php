<?php
/**
 * Messenger Bot class
 */
class MessengerBot
{
	public $args;

	protected $messenger;

	protected $messenger_response;

	protected $events = array();

	public function __construct($args = array())
	{
		$this->messenger = new FacebookMessageReceive;
		$this->messenger_response = new FacebookMessageResponse;

		if ( ! empty($args))
			$this->set_args($args);
	}

	protected function get_args() {
		return $this->args;
	}

	protected function set_args($args) {
		$this->args = $args;
	}

	public function get_userid() {
		return $this->messenger->getSender();
	}

	public function get_time() {
		return $this->messenger->getTime();
	}

	public function get_id() {
		return $this->messenger->getID();
	}

	public function add($type, $args)
	{
		if($type == 'default') {
			foreach($args as $k => $v) {
				$this->args['default'][] = $v;
			}
			return $this;
		}
		foreach($args as $key => $val) {
			foreach($val as $k => $v) {
				$this->args[$type][$key][$k] = $v;
			}
		}
		return $this;
	}

	public function call($type, $content) {
		$this->messenger_response->{$type}($content);
	}

	public function run()
	{
		//If receive delivery message
		if ($this->messenger->getDelivery()) {
			$this->fire('delivery');
			return file_put_contents( "delivery.log", serialize( $this->messenger->getMessage() ) );
		}

		if ($q = $this->messenger->getMessagingMessage()->text) {
			$this->fire('send');
			foreach ($this->args['text'] as $ask => $answer) {
				if ($ask == $q) {
					foreach($answer as $action) {
						$this->call($action['type'], $action['content']);
					}
					return true;
				}
			}
		}

		if ($p = $this->messenger->getMessagingPostbackPayload()) {
			$this->fire('send');

			$this->fire('send_payload');

			foreach ($this->args['payload'] as $payload => $config) {
				if ($p == $payload) {
					foreach($config as $action) {
						$this->call($action['type'], $action['content']);
					}
					return true;
				}
			}
		}

		foreach ($this->args['default'] as $action) {
			$this->call($action['type'], $action['content']);
		}

		return false;
	}

	/**
	 * Messenger Bot Event Handler
	 *
	 * @param $event string name.
	 * @param $callback array function to callback
	 * @return void
	 */
	public function on($event, $callback = array())
	{
		if (is_callable($callback))
			$this->events[$event][] = $callback;
	}

	public function fire($event)
	{
		if ($this->events[$event] != null) {
			foreach ($this->events[$event] as $callback) {
				call_user_func($callback);
			}
		}
	}
}