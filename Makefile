build:
	docker-compose build --no-cache && make up
up:
	docker-compose up -d
down:
	docker-compose down
db-create:
	docker-compose exec database bash -c "psql -U postgres kenshuu_backend -f /sql/init.sql"
db-exec:
	docker-compose exec database bash -c "psql -U postgres kenshuu_backend"
