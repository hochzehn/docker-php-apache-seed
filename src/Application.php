<?php

namespace Application;

class Application
{

    public function run($parameters) {
        $message = sprintf(
            Configuration::get('application/hello_message'),
            implode(' & ', $parameters)
        );

        echo $message;
    }

}
