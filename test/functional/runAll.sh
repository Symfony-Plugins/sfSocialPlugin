#!/bin/sh
# shell script to execute all functional tests

for i in `ls *.php`;
do
 php $i;
done
