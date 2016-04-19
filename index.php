<?php

use Acme\Application;
use Acme\FileLogger;
use Purist\Application\EndpointApplication;
use Purist\Server\PuristServer;

try {
    (new PuristServer(new Application))->serve();
} catch (Exception $exception) {
    (new FileLogger('/var/log/application/error.log'))->log($exception);

    // Error page PHP 5.6
    (new PuristServer(
        new EndpointApplication(new ErrorPage)
    ))->serve();

    // Error page PHP 7
    (new PuristServer(
        new class implements Application {
            public function run() {
                return new ErrorPage;
            }
        }
    ))->serve();
}
