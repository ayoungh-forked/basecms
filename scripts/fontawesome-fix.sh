#!/bin/bash

# Fix path references in Fontawesome CSS files to match usage in BaseCMS. Run 
# this with any upgrade.
#
# Pass in the list of files as the arguments to the script.

for f in $@; do
    sed -i 's/\.\.\/font/\/fonts\/fontawesome/gp' $f
done
