#!/bin/bash

cat directories.txt | while read f
do
    echo "$f"
    mkdir -p "../build/${f}"
    cd "src"
    tar -zcvf "../build/${f}/master.tar.gz" "./${f}"
    zip -r "../build/${f}/master.zip" "./${f}"
done