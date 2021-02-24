#!/bin/bash

for path in $(find /home/ -type d -name "cache_zone"); do

	find "$path/." -not -path "$path/." -type d -exec rm -rf {} +

done