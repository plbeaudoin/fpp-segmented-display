#!/bin/sh

echo "Running fpp-segmented-display PreStart Script"

BASEDIR=$(dirname $0)
cd $BASEDIR
cd ..
make "SRCDIR=${SRCDIR}"