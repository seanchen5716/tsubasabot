<?php
$bot = new MessengerBot( array(
	'text'    => array(
		'Show text'              => array(
			array(
				'type'    => 'text',
				'content' => 'Hello World!'
			)
		),
		'Say hello'              => array(
			array(
				'type'    => 'text',
				'content' => 'Hello world!'
			)
		),
		'Show buttons'           => array(
			array(
				'type'    => 'button',
				'content' => array(
					'text'    => 'Choose one from these button',
					'buttons' => array(
						array(
							'type'  => 'web_url',
							'url'   => 'https://ntvinh.com',
							'title' => 'Show website'
						),
						array(
							'type'    => 'postback',
							'payload' => 'GoShopping',
							'title'   => 'Go Shopping'
						)
					)
				)
			),
		),
		'Show image'             => array(
			array(
				'type'    => 'image',
				'content' => 'http://static1.squarespace.com/static/51dde717e4b01d6e75f8675b/55c2ae9be4b03265cd2c9f63/55c2af4fe4b01ce745178d4f/1438822223425/breadcat.jpg'
			),
		),
		'Show me the cat'        => array(
			array(
				'type'    => 'image',
				'content' => 'http://petsubjectsrescue.petethevet.com/wp-content/uploads/2014/01/cat.png'
			),
		),
		'Show generic'           => array(
			array(
				'type'    => 'generic',
				'content' => array(
					array(
						"title"     => "Classic White T-Shirt",
						"image_url" => "http://petersapparel.parseapp.com/img/item100-thumb.png",
						"subtitle"  => "Soft white cotton t-shirt is back in style",
						"buttons"   => array(
							array(
								"type"  => "web_url",
								"url"   => "https://ntvinh.com",
								"title" => "Show website"
							),
							array(
								"type"    => "postback",
								"payload" => "AddToCart",
								"title"   => "Add to cart"
							)
						)
					),
					array(
						"title"     => "Classic White T-Shirt",
						"image_url" => "http://petersapparel.parseapp.com/img/item100-thumb.png",
						"subtitle"  => "Soft white cotton t-shirt is back in style",
						"buttons"   => array(
							array(
								"type"  => "web_url",
								"url"   => "https://ntvinh.com",
								"title" => "Show website"
							),
							array(
								"type"    => "postback",
								"payload" => "AddToCart",
								"title"   => "Add to cart"
							)
						)
					),
				)
			),
		),
		'Show receipt'           => array(
			array(
				'type'    => 'receipt',
				'content' => array(
					'name'           => 'Mr Jone Doe',
					'order_number'   => rand( 0, 99999999999 ),
					'currency'       => 'USD',
					'payment_method' => 'Visa',
					'order_url'      => 'https://ntvinh.com/',
					'elements'       => array(
						array(
							"title"     => "Classic White T-Shirt",
							"subtitle"  => "100% soft and luxurious cotton",
							"quantity"  => 2,
							"price"     => 50,
							"currency"  => "USD",
							"image_url" => "http://petersapparel.parseapp.com/img/whiteshirt.png"
						),
						array(
							"title"     => "Classic Gray T-Shirt",
							"subtitle"  => "99% soft and luxurious cotton",
							"quantity"  => 2,
							"price"     => 100,
							"currency"  => "VND",
							"image_url" => "http://petersapparel.parseapp.com/img/grayshirt.png"
						)
					),
					'address'        => array(
						"street_1"    => "1st Tran Hung Dao, Ba Dinh, Ha Noi",
						"street_2"    => "2nd Le Van Luong, Ha Noi",
						"city"        => "Hanoi",
						"postal_code" => "100000",
						"state"       => "HN",
						"country"     => "VN"
					),
					'summary'        => array(
						"subtotal"      => 150.00,
						"shipping_cost" => 20.00,
						"total_tax"     => 10.00,
						"total_cost"    => 120.00
					),
					'adjustments'    => array(
						array(
							"name"   => "New customer discount",
							"amount" => 20
						),
						array(
							"name"   => "10% off coupon code",
							"amount" => 10
						)
					)
				)
			)
		),
		'Show image and buttons' => array(
			array(
				'type'    => 'image',
				'content' => 'http://static1.squarespace.com/static/51dde717e4b01d6e75f8675b/55c2ae9be4b03265cd2c9f63/55c2af4fe4b01ce745178d4f/1438822223425/breadcat.jpg'
			),
			array(
				'type'    => 'button',
				'content' => array(
					'text'    => 'Choose one from these button',
					'buttons' => array(
						array(
							'type'  => 'web_url',
							'url'   => 'https://ntvinh.com',
							'title' => 'Show website'
						),
						array(
							'type'    => 'postback',
							'payload' => 'GoShopping',
							'title'   => 'Go Shopping'
						)
					)
				)
			),
		)
	),
	'payload' => array(
		'GoShopping' => array(
			array(
				'type'    => 'text',
				'content' => 'Click add to cart to get receipt'
			),
			array(
				'type'    => 'generic',
				'content' => array(
					array(
						"title"     => "Classic White T-Shirt",
						"image_url" => "http://petersapparel.parseapp.com/img/item100-thumb.png",
						"subtitle"  => "Soft white cotton t-shirt is back in style",
						"buttons"   => array(
							array(
								"type"  => "web_url",
								"url"   => "https://ntvinh.com",
								"title" => "Show website"
							),
							array(
								"type"    => "postback",
								"payload" => "AddToCart",
								"title"   => "Add to cart"
							)
						)
					),
					array(
						"title"     => "Classic White T-Shirt",
						"image_url" => "http://petersapparel.parseapp.com/img/item100-thumb.png",
						"subtitle"  => "Soft white cotton t-shirt is back in style",
						"buttons"   => array(
							array(
								"type"  => "web_url",
								"url"   => "https://ntvinh.com",
								"title" => "Show website"
							),
							array(
								"type"    => "postback",
								"payload" => "AddToCart",
								"title"   => "Add to cart"
							)
						)
					),
				)
			),
		),
		'AddToCart'  => array(
			array(
				'type'    => 'text',
				'content' => 'This product has been added to your cart'
			),
			array(
				'type'    => 'receipt',
				'content' => array(
					'name'           => 'Mr Jone Doe',
					'order_number'   => rand( 0, 99999999999 ),
					'currency'       => 'USD',
					'payment_method' => 'Visa',
					'order_url'      => 'https://ntvinh.com/',
					'elements'       => array(
						array(
							"title"     => "Classic White T-Shirt",
							"subtitle"  => "100% soft and luxurious cotton",
							"quantity"  => 2,
							"price"     => 50,
							"currency"  => "USD",
							"image_url" => "http://petersapparel.parseapp.com/img/whiteshirt.png"
						),
						array(
							"title"     => "Classic Gray T-Shirt",
							"subtitle"  => "99% soft and luxurious cotton",
							"quantity"  => 2,
							"price"     => 100,
							"currency"  => "VND",
							"image_url" => "http://petersapparel.parseapp.com/img/grayshirt.png"
						)
					),
					'address'        => array(
						"street_1"    => "1st Tran Hung Dao, Ba Dinh, Ha Noi",
						"street_2"    => "2nd Le Van Luong, Ha Noi",
						"city"        => "Hanoi",
						"postal_code" => "100000",
						"state"       => "HN",
						"country"     => "VN"
					),
					'summary'        => array(
						"subtotal"      => 150.00,
						"shipping_cost" => 20.00,
						"total_tax"     => 10.00,
						"total_cost"    => 120.00
					),
					'adjustments'    => array(
						array(
							"name"   => "New customer discount",
							"amount" => 20
						),
						array(
							"name"   => "10% off coupon code",
							"amount" => 10
						)
					)
				)
			)
		)
	),
	'default' => array(
		array(
			'type'    => 'text',
			'content' => "You can type 'help', 'Show text', 'Show buttons', 'Show image', 'Show generic', 'Show image and buttons' to see our example function with text"
		)
	)
) );

$bot->add( 'text', array(
	'help' => array(
		array(
			'type'    => 'text',
			'content' => 'This script is added by add(\'text\', $script) function.'
		),
		array(
			'type'    => 'button',
			'content' => array(
				'text'    => 'You can See documentation to get more detail',
				'buttons' => array(
					array(
						'type'  => 'web_url',
						'url'   => 'https://ntvinh.com/fb/documentation.html',
						'title' => 'See documentation'
					),
					array(
						'type'    => 'postback',
						'payload' => 'GoShopping',
						'title'   => 'Go shopping'
					),
					array(
						'type'    => 'postback',
						'payload' => 'WatchTrailer',
						'title'   => 'Watch Trailers'
					)
				)
			)
		)
	)
) );

$bot->add( 'payload', array(
	'WatchTrailer' => array(
		array(
			'type'    => 'text',
			'content' => 'This script is added by add(\'payload\', $script) function.'
		),
		array(
			'type'    => 'button',
			'content' => array(
				'text'    => 'Click one of these link to watch the trailer',
				'buttons' => array(
					array(
						'type'  => 'web_url',
						'url'   => 'https://www.youtube.com/watch?v=-BlRN0bVPuo',
						'title' => 'Dr. Strange Trailer'
					),
					array(
						'type'  => 'web_url',
						'url'   => 'https://www.youtube.com/watch?v=MZwsbcW-d-E',
						'title' => 'Suicide Squad Trailer'
					)
				)
			)
		)
	)
) );

$bot->add( 'default', array(
	array(
		'type'    => 'button',
		'content' => array(
			'text'    => 'Or you can click one from these button to see example action with payload or web url',
			'buttons' => array(
				array(
					'title' => 'Visit website',
					'type'  => 'web_url',
					'url'   => 'https://ntvinh.com'
				),
				array(
					'title'   => 'Go Shopping',
					'type'    => 'postback',
					'payload' => 'GoShopping'
				)
			)
		)
	)
) );

$bot->run();