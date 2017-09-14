#!/usr/bin/env bash

mkdir /tmp/myMemoryDrive

sudo mount -t tmpfs /mnt/tmpfs /tmp/myMemoryDrive

php -r "file_put_contents('/tmp/myMemoryDrive/test.txt',\"Hello\n\");"

cat /tmp/myMemoryDrive/test.txt

sudo umount /mnt/tmpfs

cat /tmp/myMemoryDrive/test.txt
