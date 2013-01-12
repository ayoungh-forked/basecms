#!/bin/bash

# Passed a .zip archive of a new Bootstrap version, this script will install
# the update over the current core BaseCMS installation and perform the
# necessary tweaks.

USAGE="\n$0 <bootstrap zip file>\n"

if [ -z "$1" ]; then
    echo -e "$USAGE" >&2
    exit 1
fi

BASEDIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && cd .. && pwd)"
TMPDIR="/tmp/base-bootstrap-$(date +%s)/"

echo 'Created a temporary directory at' $TMPDIR
echo 'Unpacking ...'

cp $1 $TMPDIR/
cd $TMPDIR
unzip $1

mv -v css/* $BASEDIR/public/styles/vendor/bootstrap/
mv -v js/* $BASEDIR/public/scripts/vendor/bootstrap/
mv -v img/* $BASEDIR/public/images/bootstrap/

$BASEDIR/scripts/bootstrap-fix.sh -v $BASEDIR/public/scripts/vendor/bootstrap/*

cd -

echo 'Cleaning up ...'
rm -rvf $TMPDIR
