#!/bin/sh

filespath=$2
: ${filespath:=$(pwd)}

for file in `find "${filespath}/src" -name *.php`
do
    sed -i "s/@version \(.*\)/@version $1/" $file
    echo "Updated $(basename $file)"
done

for file in `find "${filespath}/unittests/src" -name *.php`
do
    sed -i "s/@version \(.*\)/@version $1/" $file 
    echo "Updated $(basename $file)"
done

echo "Done updating to $1"