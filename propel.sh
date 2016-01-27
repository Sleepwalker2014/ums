#! /bin/bash
./vendor/propel/propel/bin/propel reverse --output-dir=db/ 
./vendor/propel/propel/bin/propel build --schema-dir=db/ --output-dir=db/
