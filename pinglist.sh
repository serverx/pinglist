#!/bin/sh
DIR=/usr/local/sbin
for i in `awk {'print $1'} $DIR/pinglist.txt`; do
	$DIR/ping.sh $i
done
