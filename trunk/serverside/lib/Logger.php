<?php


class Logger {
	public static $file;
	private static $trackback;
	private static $logsql;

	private static $db_querys = 0;

	public static final function sql($sql) {
		if (self::$logsql) {
			self::$db_querys++;
			self::log("SQL(" . self::$db_querys . "): " . $sql);
		}
	}

	public static final function info($msg) {
		self::log($msg);
	}

	public static final function error($msg) {
		self::log("ERROR | " . $msg);
	}

	public static final function warn($msg) {
		self::log("WARN | " . $msg);
	}

	private static final function log($msg, $level = 0) {
		if (is_null(self::$file)) {
			return;
		}

		if (!file_exists(self::$file)) {
			error_log("Unable to log to: " . self::$file);
			return;
		}

		if (!is_writable(self::$file)) {
			die("self::$file");
			return;
		}

		$handle = fopen(self::$file, "a");
		$out = date(DATE_RFC822);

		if (isset($_SERVER["REMOTE_ADDR"])) {
			$out .= " | " . $_SERVER["REMOTE_ADDR"];
		}

		$out .= " | [frontend]";

		if (self::$trackback) {
			$d = debug_backtrace();
			$track = " | TRACK : ";
			for ($i = 1; $i < sizeof($d) - 1; $i++) {
				$track .= isset($d[$i]["file"]) ? substr(strrchr($d[$i]["file"], "/"), 1) : "*";
				$track .= isset($d[$i]["line"]) ? ":" . $d[$i]["line"] . " " : "* ";
			}
			$out .= $track;
		}

		fwrite($handle, $out . " | " . $msg . "\n");
		fclose($handle);
	}
}
