#!/bin/bash

FILE=/etc/resolv.conf
if test -f "$FILE"; then
    echo "$FILE exists."
else 
    echo "$FILE does not exist."
fi