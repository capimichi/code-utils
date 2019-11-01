#!/bin/bash

cat directories.txt | while read f
do
    echo "$f"
    mkdir -p "./build/${f}"
    tar -zcvf "./build/${f}/master.tar.gz" "./src/${f}"
    zip -r "./build/${f}/master.zip" "./src/${f}"
done