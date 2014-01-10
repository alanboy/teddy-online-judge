<?php

class c_backup extends c_controller
{
	public static function BackupDatabase()
	{
		global $TEDDY_DB_USER;
		global $TEDDY_DB_PASS;
		global $PATH_TO_BACKUPS;

		$output = `mysqldump --user=$TEDDY_DB_USER--password=$TEDDY_DB_PASS --add-drop-table teddy  | gzip > $PATH_TO_BACKUPS/latest.sql.gz`;

		echo $output;
	}

	function BackupCodigos()
	{

	}	
}

