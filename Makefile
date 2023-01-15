build:
	docker-compose build
	${MAKE} up

up:
	docker-compose up -d
	docker-compose exec app composer install
	cp .env.sample .env
    # 	docker-compose exec app php vendor/bin/phinx migrate

down:
	docker-compose down -v

ps:
	docker-compose ps

logs:
	docker-compose logs -f

bash:
	docker-compose exec app sh