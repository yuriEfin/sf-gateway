#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
	CREATE USER crazy;
	CREATE DATABASE symfony-pgsql;
	GRANT ALL PRIVILEGES ON DATABASE crazy TO symfony-pgsql;
EOSQL