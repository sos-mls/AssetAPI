#!/bin/bash

IP_ADDRESS=$(ifconfig eth1 | grep 'inet addr' | cut -d ':' -f 2 | cut -d ' ' -f 1)

sudo sudo -E bash $SHELL_HOME/install/helpers/output-block.sh "You can access your server by entering this IP in your browser: ${IP_ADDRESS}"