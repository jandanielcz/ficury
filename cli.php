<?php

require "vendor/autoload.php";
require "conf/services.php";

$cli = $c->get(\splitbrain\phpcli\PSR3CLI::class);
$cli->run();