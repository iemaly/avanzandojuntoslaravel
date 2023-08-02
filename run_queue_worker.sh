#!/bin/bash

php /home/imranfront/public_html/avanzandojuntoslaravel/artisan queue:work --tries=3 --sleep=3 --timeout=60 > /dev/null 2>&1