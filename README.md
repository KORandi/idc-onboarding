# Restaurantly

## Prerequisites
* Docker
* Git
* Free ports: 8080, 9100

## Run the project

1. Open empty directory
2. Open CMD
3. Run these commands
```
git clone https://github.com/KORandi/idc-onboarding.git
cd ./idc-onboarding
docker-compose up -d
docker exec -it php74-container composer install
docker-compose run --rm node-service yarn install
docker-compose run --rm node-service yarn build
docker exec -it php74-container cron #in case you want to start cron which sends email every morning at 9am on working days
```
4. open localhost:8080

## Homepage
There is a list of restaurants, when you click on title it will redirects to the menu

## Menu restaurant subscription
Fill the form and send it. Now you are subscribed to these restaurant menus, and you will recieve their menu list every morning at 9am
