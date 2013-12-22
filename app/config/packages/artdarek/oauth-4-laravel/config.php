<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		*/
	'Facebook' => array(
	    'client_id'     => '441082479326928',
	    'client_secret' => 'f4f8f2bfcb894051402a4a881c8fb6d1',
	    'scope'         => array('email','read_friendlists','user_online_presence'),
	),  

		/**
		* Google
		*/
	'Google' => array(
	    'client_id'     => '969530279823.apps.googleusercontent.com',
	    'client_secret' => '5LGPPhYqNFmiBcYbFCbQlB8f',
	    'scope'         => array('userinfo_email', 'userinfo_profile'),
	),  

	)

);
