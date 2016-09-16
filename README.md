    
# Package-template

Use this template package structure to build your own packages and tests

## Structure

* files - package files
* src - package src files
* tests - package PHPUnit tests
* tests/classes - classes needed for testing
* tests/files - files needed for testing
* tests/bootstrap.php - PHPUnit autoloading and helpers

## Helpers

* packageFile($name) - get full name of file with name=$name in **files** folder
* packageTestFile($name) - get full name of file with name=$name in **tests/files** folder

## Run tests

For testing PHPUnit installed required

```
cd package-template
composer install
phpunit ./tests
```

