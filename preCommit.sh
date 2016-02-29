#!/bin/bash
./vendor/bin/phpunit -c app/phpunit.xml
./vendor/bin/phpcs --config-set default_standard PSR2
./vendor/bin/phpcs src
#./vendor/bin/sami.php update config/sami.php

#no need on dev, but great for optimising autoload
#composer dump-autoload --optimize
