#!/bin/sh

filespath=$1
: ${filespath:=$(pwd)}

for file in ${filespath}/src/Flikore/Validator/Validators/*
do
    var=$(basename $file)
    echo $var | sed "s/\(.*\)\.php/* \`\1\`/"
done