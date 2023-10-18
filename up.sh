#!/bin/bash
docker-compose stop 
docker-compose rm -vf php
docker-compose build
docker-compose up -d
