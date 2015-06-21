#!/usr/bin/env bash
set -e

touch "$TRAVIS_BUILD_DIR/server.log"
echo  "Starting the PHP builtin webserver"
php -S 127.0.0.1:3000 -t "$TRAVIS_BUILD_DIR/test" > /dev/null 2> "$TRAVIS_BUILD_DIR/server.log" &
