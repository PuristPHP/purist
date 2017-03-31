<?php

use Acme\Application;
use Acme\FileLogger;
use Purist\ResourceApplication;
use Purist\Server\ApplicationServer;

try {
    (new ApplicationServer(new Application))->handle(
        ServerRequest::fromGlobals()
    );
} catch (Exception $exception) {
    (new FileLogger('/var/log/application/error.log'))->log($exception);

    // Error page PHP 5.6
    (new ApplicationServer(
        new ResourceApplication(new ErrorPage)
    ))->serve();

    // Error page PHP 7
    (new ApplicationServer(
        new class implements Application {
            public function run() {
                return new ErrorPage;
            }
        }
    ))->serve();
}
