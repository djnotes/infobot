#!/bin/bash

# Reads environment variables from local/env and exports them
# Run this script before running docker-compose.yaml

for line in $(cat ./local/env);
  do echo "Exporting $line"; export $line;
done

