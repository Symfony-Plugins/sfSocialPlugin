#!/bin/sh
# shell script to execute all functional tests
# for older symfony versions (< 1.3)

for i in `ls *.php`;
do
 php $i;
done
