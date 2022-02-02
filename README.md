# REST API to serve/edit calendar events

The purpose of this component is to enable web based clients to manage calendar events (aka meetings).

A meeting consists of:
- owner - DONE
- start time - DONE
- end time - DONE
- name - DONE
- meeting room - DONE

Two meetings can't be placed in the same room at the same time. - DONE

The API should allow for:
- list all meetings an user (owner) has for a particular day
- list all meetings an user (owner) has ever had - DONE
- create new meeting - DONE

The API specification is for the candidate to decide but it should follow the REST architectural style. Please provide basic documentation of it so we can test. Please provide steps to run or deploy it on the internet.
The implementation should be done with PHP and the Laravel framework.

For simplicity you could assume there is only one meeting owner (user).

Bonus points:
- add basic authentication - Basic auth is implemented, api_token is added to Users table, overwrite RegistersUsers.php/registered() and AuthenticatesUsers.php/ login(), created function in User.php/generateToken(), unfortunately it does not work user is always unauthenticated.
- use Swagger for specification - DONE
- ![img_8.png](img_8.png)
- to generate documentation: php artisan l5-swagger:generate to run: http://127.0.0.1:8000/api/documentation
- add update and delete meeting methods - DONE


How to run it?

1. Download and install xampp https://www.apachefriends.org/download.html

2. Install Composer https://getcomposer.org/Composer-Setup.exe

3. Open Git bash or PowerShell

4. Navigate to project directory ex: cd /c//xampp/htdocs/

5. composer global require "laravel/installer=~1.1"

6. git clone git@github.com:sashokrist/event_api_task.git

7. cd laravel-api-task

8. composer install

9. cp .env.example .env

10. php artisan key:generate

11. php artisan migrate

12. php artisan db:seed

13. php artisan serve

Open project on localhost:8000

http://127.0.0.1:8000/api/register ![img.png](img.png) http://127.0.0.1:8000/api/login ![img_1.png](img_1.png) http://127.0.0.1:8000/api/meets ![img_2.png](img_2.png) http://127.0.0.1:8000/api/meet/1 ![img_3.png](img_3.png) http://127.0.0.1:8000/api/meet/1 ![img_4.png](img_4.png) http://127.0.0.1:8000/api/meet/1 ![img_5.png](img_5.png) http://127.0.0.1:8000/api/meets-user ![img_6.png](img_6.png)
