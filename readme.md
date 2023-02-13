PHP stock market api POC
===================

## Before install
Make sure you have installed Docker Desktop. If you don't, follow the <a href="https://www.docker.com/get-started" target="_blank">Get Started with Docker</a>.


## Installation guide

#### Clone the project
    $ git clone git@github.com:danilocolasso/slim-stock-market-poc.git

#### Enter project folder
    
    $ cd php-challenge

#### Up the containers
    $ make up

#### Change the mailer settings on .env to a valid one
    MAILER_HOST=
    MAILER_PORT=
    MAILER_USERNAME=
    MAILER_PASSWORD=

By default I left my data so it should work. But I advise you to change it.

**All done!** Everything should work wth a single command. The application will be available at
http://localhost/

## User guide
There are only 4 endpoints:
- User registration
- User login
- Stock Quote
- Stock Quote History

### User registration
Type: public

Method: POST

Endpoint: http://localhost/user/register

Expected parameters:
- username
- password
- name
- email

### User login
Type: public

Method: POST

Endpoint: http://localhost/user/login

Expected parameters:
- username
- password


### Stock Quote
Type: protected

Method: GET

Endpoint: http://localhost/stock

Expected headers:
- Authorization

Expected parameters:
- q : The stock code to search

  e.g.: http://localhost/stock?q=aapl.us

The Authorization must be the same provided by login action.

### Stock Quote History
Type: protected

Method: GET

Endpoint: http://localhost/history

Expected headers:
- Authorization

The Authorization must be the same provided by login action too.


## TO DO
- Use Respect or code some class to validate controller input
- Use translations to avoid string messages on code
- A better Exception Handler with customized Exceptions, to know which Exceptions I can show to user
- Improve JWT payload for security, like add IP
- Use DTO to avoid mistakes with array
- Use timestamp on "time" column. I decided to use string to simplify
- Add tests for EmailService, UserLogin and Registration Services
- Add more tests for StooqService
- Use RabbitMQ to send e-mails asynchronously


<h4 align="center">
    Made with ♡ by <a href="https://www.linkedin.com/in/danilocolasso/" target="_blank">Danilo Colasso</a>
</h4>