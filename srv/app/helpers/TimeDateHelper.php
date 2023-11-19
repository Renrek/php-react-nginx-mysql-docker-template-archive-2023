<?php
use DateTimeZone;
//Notes for time date class
$timezone_identifiers = DateTimeZone::listIdentifiers();
$time = time();
date_default_timezone_set("America/Chicago");
$readable = date("Y-m-d H:i:s", $time);