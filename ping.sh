#!/bin/sh

# FreeBSD (timeout in milliseconds) / Linux (timeout in seconds)
W="1"

YEAR=`date +%Y`
MONTH=`date +%Y-%m`
DAY=`date +%Y-%m-%d`
REMOTE=$1
DIR=/var/log/ping
[ ! -d $DIR ] && mkdir $DIR
DIR=/var/log/ping/$YEAR
[ ! -d $DIR ] && mkdir $DIR
DIR=/var/log/ping/$YEAR/$MONTH
[ ! -d $DIR ] && mkdir $DIR
DIR=/var/log/ping/$YEAR/$MONTH/$DAY
[ ! -d $DIR ] && mkdir $DIR
FILE=/var/log/ping/$YEAR/$MONTH/$DAY/$REMOTE.txt

RESULT=`ping -c1  -W$W $REMOTE | grep 'bytes from' | cut -d'=' -f4`

if [ -z "$RESULT" ] ;  then
        RESULT="FAILED"
fi
if [ `echo $RESULT | grep exceed | wc -l` -gt 0 ] ; then
	RESULT="FAILED"
fi
if [ `echo $RESULT | grep Unreachable | wc -l` -gt 0 ] ; then
	RESULT="FAILED"
fi
echo `date` $RESULT >> $FILE
