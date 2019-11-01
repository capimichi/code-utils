#!/bin/bash

BASEDIR="$( cd "$(dirname "$0")" ; pwd -P )"

cat directories.txt | while read f
do
    cd "$BASEDIR"
    mkdir -p "./build/${f}"
    cd "./src/${f}"
    tar -zcvf "${BASEDIR}/build/${f}/master.tar.gz" "."
    zip -r "${BASEDIR}/build/${f}/master.zip" "."
done