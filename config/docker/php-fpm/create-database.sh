#!/bin/bash

# this is needed to wait mysql server to be up
for COUNTER in `seq 1 35`
do
    nc -z database 3306;
    if [ $? = 0 ]; then

        echo "create and populate database"
        cd /user/progetto
        php bin/console do:da:cr
        php bin/console do:s:u --force
        php bin/console do:fi:lo -n

        # we still do not use encore...
        #bin/encore dev --watch

        exec "$@";
    else
        echo "Waiting for MySQL..."
        sleep 2;
    fi
done
echo "MySQL IS NOT UP!"
exit 1;
