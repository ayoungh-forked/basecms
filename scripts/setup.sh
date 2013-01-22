#!/bin/bash

usage() {
    echo "Create a basic, empty BaseCMS file setup in the specified directory."
    echo "$0 <directory path>"
}

makebasedirs() {
    cd $arg
    mkdir -p config
    mkdir -p lib/vendor
    mkdir -p migrations/mysql
    mkdir -p public/scripts
    mkdir -p public/styles
    mkdir -p public/images
    mkdir -p public/fonts
    mkdir -p templates/skins
    mkdir -p templates/error_pages
    cd -
}

if [ -z "$1" ]; then
    usage
    exit 1
fi

for arg in $@; do
    case $arg in
        -h|--h)
            usage
            exit
            ;;
        *)
            makebasedirs $arg
            ;;
    esac
done
