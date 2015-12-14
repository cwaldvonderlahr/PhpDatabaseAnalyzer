# PhpDatabaseAnalyzer

![Scrutinizer Score](https://scrutinizer-ci.com/g/cwaldvonderlahr/PhpDatabaseAnalyzer/badges/quality-score.png?b=master)

Project is still in dev. 

## idea
- simple
- awesome
- clean
- fun

## facts
- written in PHP7
- helpful for database architects
- ready for performance geeks

## supported databases
- mySQL5

## tests
- Database Tests
- Table Tests
- Field Tests

## output-Formats
- XML
- HTML

## code
- PSR-0 Autoloader
- PSR-1 Coding Standard
- PSR-2 Codestyle

## installation

###1. download project
Download the master.

###2. Composer install
Run "composer install".
Example: "php composer.phar install" from https://getcomposer.org/download/ 

###3. Config
Create your own config file. You can use the example file in "<Project folder>/config/".

###4. Run...
####4.1 command line
#####4.1.1 ...with own config
Use "php phpDatabaseAnalyzer.php CONFIG-FILE". Replace CONFIG-FILE with the absolue path to our own config file. 
If this file doesn't exists the script will try to use the default config from "<Project folder>/config/config.xml"..
If this file doesn't exists you'll get an exception.

#####4.1.2 ...with config from config folder
Use "php phpDatabaseAnalyzer.php" without any parameter. 
The script will automatically use the config file from "<Project folder>/config/config.xml".
If this file doesn't exists you'll get an exception.

####4.2 Browser
You can start the script in your browser by using "phpDatabaseAnalyzer.php" without any parameters.
The script will use the config from "<Project folder>/config/config.xml".
If this file doesn't exists you'll get an exception.

####4.3 Save output

#####Mac OS / Linux
To save the output in a file use "php phpDatabaseAnalyzer.php > OUTPUT-FILE".
Replace "OUTPUT-FILE" with the name of the file in which the output should be saved.
Example: 
"php phpDatabaseAnalyzer.php > result.xml"

#####Windows

## future plan

work on 0.2

## credits
- Chrissi (https://github.com/cwaldvonderlahr)
- Fred (https://github.com/fgluecks)
