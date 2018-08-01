# Application to manage user accounts

### Steps to run project on docker
1. Clone repository
2. Run command `docker-compose build` in project folder
3. Run command `docker-compose up -d` in project folder
4. Run command `docker exec -it telemedi_server bash`
5. Run command on telemedi_server shell `php bin/console doctrine:schema:update -f`
6. Run command on telemedi_server shell `php bin/console doctrine:migrations:migrate --no-interaction`

### Log in application
Please send the following JSON:
```
{
	"username": "test",
	"password": "test"
}
```