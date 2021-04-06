<?php

require "vendor/autoload.php";
require "conf/services.php";

$c = createContainer();

$cli = $c->get(\splitbrain\phpcli\PSR3CLI::class);
$cli->run();