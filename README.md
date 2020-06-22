# DB & SEEDING
```bash
php cli.php orm:schema-tool:update -f 
php cli.php doctrine:fixtures:load
```
# RUN IN DOCKER
Add to /etc/hosts:
```
127.0.0.1 minifw.loc
``` 
Nginx bind minifw.loc on port 1080
http://minifw.loc:1080/

# TODO
1. Add controller argument resolver for working with application container
2. Improve console register commands
3. Implement caching