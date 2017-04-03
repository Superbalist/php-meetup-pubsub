up:
	@docker-compose rm -f
	@docker-compose up --build -d
	@echo You can access the website at http://$$(docker-machine ip)

down:
	@docker-compose stop -t 1

bash:
	@docker exec -i -t phpmeetuppubsub_php-meetup-pubsub-web_1 /bin/bash