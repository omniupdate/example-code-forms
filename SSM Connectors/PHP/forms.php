<?php
/*
error_reporting(E_ALL);
ini_set("display_errors", 1);
*/
require_once('class.ouldp.php');
$ldp_conf = array();

/***** CONFIGURATION *****/

$_ENV['ldp_config']['ssm_host'] = "http://127.0.0.1"; //SSM Host location. Change this if the SSM is on a different server than the connector script.
$_ENV['ldp_config']['ssm_port'] = "7518";
$_ENV['ldp_config']['ssm_path'] = "";
$_ENV['ldp_config']['webroot'] = $_SERVER['DOCUMENT_ROOT'];

// ADD Site Names and UUIDs

$site_uuids = array(
	 "CHANGE-THIS-SITE-NAME" => "102971fd-8a2b-4e8a-9e2a-03e19030d2ac",
     "test" => "3029sfd-8a2b-4e9a-9e2a-03e19030d2ac",
	
);

/*************************/

$site_name=$_POST['site_name'];
$site_uuid=$site_uuids[$site_name];
$_ENV['ldp_config']['site_uuid'] = $site_uuid;

$form_uuid = $_POST['form_uuid'];
if(!count($_POST)) {

        $func = "ldp.form.enabled";
        $params = array($_ENV['ldp_config']['site_uuid'], $form_uuid);

        $sendForm = new ouldp();

        $result = $sendForm->send($func,$params);

        echo json_encode($result);

   }
   elseif(count($_POST)){

    $func = "ldp.form.submit";
	$params = array($_ENV['ldp_config']['site_uuid'], $form_uuid, $_REQUEST,
			  array('OXLDP_FORM_SERVER_NAME'     => $_SERVER['SERVER_NAME'],
					'OXLDP_FORM_SERVER_IP'       => $_SERVER['SERVER_ADDR'], // LOCAL_ADDR when ssm is on a windows server
					'OXLDP_FORM_REQUEST_TIME'    => $_SERVER['REQUEST_TIME'],
					'OXLDP_FORM_HTTP_HOST'       => $_SERVER['HTTP_HOST'],
					'OXLDP_FORM_HTTP_REFERER'    => $_SERVER['HTTP_REFERER'],
					'OXLDP_FORM_HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
					'OXLDP_FORM_REMOTE_IP'       => $_SERVER['REMOTE_ADDR'],
					'OXLDP_FORM_SCRIPT_NAME'     => $_SERVER['SCRIPT_FILENAME'],
					'OXLDP_FORM_REMOTE_PORT'     => $_SERVER['REMOTE_PORT']));

	$sendForm = new ouldp();
	$result = $sendForm->send($func,$params);
    echo json_encode($result);

   }
   

?>
