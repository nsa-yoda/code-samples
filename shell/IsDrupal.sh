#!/usr/bin/env bash

curl -fsIL $1 2>&1 | grep -q -m 1 "Expires: Sun, 19 Nov 1978 05:00:00 GMT" && echo "Yes, this appears to be a Drupal site." || echo "No, this does not appear to be a Drupal site."