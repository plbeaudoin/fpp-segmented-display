#!/bin/bash

# fpp-segmented-display install script

BASEDIR=$(dirname $0)
cd $BASEDIR
cd ..
make "SRCDIR=${SRCDIR}"


. ${FPPDIR}/scripts/common
setSetting restartFlag 1