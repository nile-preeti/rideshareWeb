<?php

// use Kreait\Firebase\Factory;

 class Firebase_lib {
    protected $firebase;
    protected $database;
    
    public function __construct() {       

    //$accountPath = APPPATH . 'config\livedbtest-85407-firebase-adminsdk-epcx3-9e6cb7860a.json';
    $accountPath = APPPATH . 'config\ridesharerates-626a2-firebase-adminsdk-jb920-cdbe6fb3ed.json';
	$dbUrl='https://ridesharerates-626a2-default-rtdb.firebaseio.com/';
    $config = [
        'database_url' => $dbUrl,
        'service_account' => $accountPath
    ];

        $this->firebase = (new Kreait\Firebase\Factory())->withDatabaseUri($config['database_url']);
        $this->database = $this->firebase->createDatabase();
    }

    public function getDatabase() {
        return $this->database;
    }
}