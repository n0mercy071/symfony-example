# Docker compose
dc_build:
	docker-compose -f ./docker/docker-compose.yml build
	$(MAKE) dc_proto

dc_stop:
	docker-compose -f ./docker/docker-compose.yml stop

dc_down:
	docker-compose -f ./docker/docker-compose.yml down -v --rmi=all --remove-orphans

dc_up:
	docker-compose -f ./docker/docker-compose.yml up -d --remove-orphans

dc_pc:
	docker-compose -f ./docker/docker-compose.yml ps

dc_logs:
	docker-compose -f ./docker/docker-compose.yml logs -f

dc_proto:
	mkdir -p ./var/php
	mkdir -p ./var/grpc
	docker-compose -f ./docker/docker-compose.yml exec php-fpm bash -c "protoc \
		--php_out=./var/php/ \
		--grpc_out=./var/grpc/ \
		--plugin=protoc-gen-grpc=/usr/bin/grpc_php_plugin \
		./config/proto/screenshot.proto"

# App
app_bash:
	docker-compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bash
