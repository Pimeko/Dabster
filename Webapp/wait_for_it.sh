#!/bin/bash

while ! nc -z db 3306; do echo "Waiting for bdd" && sleep 1; done