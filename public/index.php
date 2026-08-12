<?php
require_once(dirname(__DIR__)."/app/core/SessionManager.php");
init_session();
require_once(dirname(__DIR__)."/app/core/database.php");
require_once(dirname(__DIR__)."/app/core/debug.php");
require_once(dirname(__DIR__)."/app/core/router.php");