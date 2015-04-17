<?php

/**
 *  @module	newsreader
 */ 

if(!defined('WB_PATH')) die(header('Location: ../index.php'));
 
global $lepton_filemanager;
if (!is_object($lepton_filemanager)) require_once( "../../framework/class.lepton.filemanager.php" );

$files_to_register = array(
	'/modules/newsreader/save.php'
);

$lepton_filemanager->register( $files_to_register );

?>