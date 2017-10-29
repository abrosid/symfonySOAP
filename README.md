## Requirements

composer is required

## Installation

Clone from git: 

`git clone ...`

Install dependencies using composer

`composer install`

Go to project root directory:

`cd symfonysoap`

## Run

Commamd list:
#### php ukpostcodes.php list

Example of usage with 2 city (town) names:
#### php ukpostcodes.php town:name Dalblair, Conisholme

Example of usage with 3 city (town) names:
#### php ukpostcodes.php town:name Little London, Dalblair, Conisholme'

Example of usage with less city (town) names:
#### php ukpostcodes.php town:name Little London

`Required at least 2 or maximum 3 city (town) names: Little London (1)`

Example of usage with less city (town) names:
#### php ukpostcodes.php town:name Little London, bla, bla, bla

`Required at least 2 or maximum 3 city (town) names: Little London, bla, bla, bla (4)`


## Tests

Run all test:

`phpunit -- tests`

Run ReadMeCommand test:

`phpunit -- tests\ReadMeCommandTest`

Run TownCommand test:

`phpunit -- tests\TownCommandTest`

Run ServiceProvider test:

`phpunit -- tests\ServiceProviderTest`


