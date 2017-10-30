## Summary

A sample PHP standalone CLI app, which outputs UK postcodes (locations) by entering their names, separated by comma `,` into CLI as a argument. The application is able to search exactly for two or three cities at one. If a user enters one city or more than three, the application will display error message:

`Required at least 2 or maximum 3 city (town) names: ...`

UK postcodes (locations) are retrieved from the public SOAP web service: http://www.webservicex.net/uklocation.asmx?WSDL

In this sample are used following list of components and packages:
 - Symfony/Comsole component : https://symfony.com/doc/current/components/console.html
 - Symfony/EventDispatcher: https://symfony.com/doc/current/components/event_dispatcher.html
 - SOAP client package: https://github.com/tuscanicz/BeSimpleSoap

Also this sample app includes `phpunit` test.


## Preinstalation requirements

Following php version and cli tools are required:

 - PHP 7.0 or greater : http://be2.php.net/downloads.php
 
 - `composer` Dependency Manager for PHP: https://getcomposer.org/download/

Recommended to install `phpunit` testing framework for PHP ^7.0  globally :
https://phpunit.de/manual/current/en/installation.html


## Installation

Clone the project from git: 

`git clone ...`

Go to project root directory:

`cd symfonysoap`

Install dependencies using composer:

`composer install`




## How it works...

City (town) names wil be entered as a command argument and they are must be separated by comma `,`. 
For example:
`Little London, Conisholme` will be recognized as two city names.
`Little London, ` will be recognized as one city name.

Here are the list of avialable command: 

 - `php ukpostcodes.php` - outputs readme text

 - `php ukpostcodes.php list` - displays command list

 - `php ukpostcodes.php help` - displays help and other instruktions

 - `php ukpostcodes.php readme` - outputs readme text, `readme` is the default command.

Example of usage with 2 city (town) names:

`php ukpostcodes.php town:name Dalblair, Conisholme`

Example of usage with 3 city (town) names:

`php ukpostcodes.php town:name Little London, Dalblair, Conisholme`

Example of usage with less city (town) names:

`php ukpostcodes.php town:name Little London`

Should display: 

`Required at least 2 or maximum 3 city (town) names: Little London (1)`

Example of usage with more city (town) names:

`php ukpostcodes.php town:name Little London, bla, bla, bla`

Should display: 

`Required at least 2 or maximum 3 city (town) names: Little London, bla, bla, bla (4)`


## Tests

If the `phpunit` is included to the `$PATH`, i.e. is set as a system variable, the following commands are for php unit testing.

All testings:

`phpunit tests`

ReadMeCommand testing:

`phpunit tests\ReadMeCommandTest`

TownCommand testing:

`phpunit tests\TownCommandTest`

ServiceProvider testing:

`phpunit tests\ServiceProviderTest`


