#!/bin/sh

if [ -z "$1" ]; then
    echo "No argument supplied";
    exit 1;
fi

if [ -d .subsplit ]; then
    git subsplit update
else
    git subsplit init git@github.com:orchestral/canvas.git
fi

git subsplit publish --heads="4.x" --tags=$1 src/Core:git@github.com:orchestral/canvas-core.git
