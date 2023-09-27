#!/bin/bash
docker-compose stop 
docker-compose rm -vf nginx php
docker-compose build
docker-compose up -d
