Ficury
======

Usage
-----
~~~powershell
# in powershel
$env:FICURE_ES_HOST="http://localhost:9200/"; .\php.bat .\cli.php run "\Ficury\Job\FoxentryJob"
$env:FICURE_ES_HOST="no"; php cli.php run "\Ficury\Job\FoxentryJob"
~~~