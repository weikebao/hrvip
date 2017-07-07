<?php

return [

	// The default gateway to use
	'default' => 'unionpay',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => ''
			]
		],
		'unionpay' => [
		    'driver' => 'UnionPay_Express',
		    'options' => [
		        'merId' => '700000000000001',
		        // 'certPath' => 'D:\xampp\htdocs\work\hongri\hongri\public\testcert\acp_test_sign.pfx',
		        'certPath' => 'http://vip.xinjiyuanhr.com/testcert/acp_test_sign.pfx',
		        'certPassword' =>'000000',
		        'certDir'=>'http://vip.xinjiyuanhr.com/testcert',
		        // 'certDir'=>'D:\xampp\htdocs\work\hongri\hongri\public\testcert',
		        'returnUrl' => 'http://vip.xinjiyuanhr.com/order/yinlianhoutais',
		        // 'returnUrl' => 'http://www.hongri.com/order/yinlianhoutais',//回调的地址
		        'notifyUrl' => 'http://vip.xinjiyuanhr.com/order/yinlianhoutai'
		    ]
		]
	]
];