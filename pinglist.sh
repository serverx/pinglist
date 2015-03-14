#!/bin/sh
for i in `awk {'print $1'} list.txt`; do
	ping.sh $i
done
