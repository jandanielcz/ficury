Ficury
======

Installation
------------
Use composer `composer install`

Usage
-----
Set environment variable `FICURE_ES_HOST` to elastic host and run cli script.

~~~powershell
# in powershel
$env:FICURE_ES_HOST="http://localhost:9200"; php cli.php run "\Ficury\Job\FoxentryJob"
$env:FICURE_ES_HOST="http://localhost:9200"; php cli.php run "\Ficury\Job\FapiJob"
~~~

### Not completed stuff and improvements
* add ES index to configuration
* some error check in `\Ficury\Index\ESindex::store`
* do some middle abstraction between `Job` and `FapiJob` for example 
  (`FapiJob` and `FoxentryJob` can have same feature enhancing method if access to `$url`, `$lang` and `$product` is defined)