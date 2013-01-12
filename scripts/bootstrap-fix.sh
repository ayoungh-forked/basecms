#!/bin/bash

# Fix path references in Bootstrap files to match usage in BaseCMS. Run this
# with any upgrade.
#
# Pass in the list of files as the arguments to the script.

for f in $@; do
    sed -i 's/\.\.\/img/\/images\/bootstrap/gp' $f
done
