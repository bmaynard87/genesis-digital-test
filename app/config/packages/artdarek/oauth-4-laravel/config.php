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
            'client_id'     => '437287473121641',
            'client_secret' => '48483c1c13ce88e3f4216613db8a0eaa',
            'scope'         => array('email'),
        ),
		'GitHub' => array(
			'client_id'     => '673f58a22fc4296d8475',
			'client_secret' => '465e926a56e564e3a79a9b05c93ad09b48931a19',
			'redirectUri'   => 'http://locahost/gdtest/public/auth/github/',
			'scope'         => array('user:email')
		)
	)

);