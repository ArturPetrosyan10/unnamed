@echo off
:loop
C:\OSPanel\modules\php\PHP_8.1\php.exe C:\OSPanel\domains\unnamed\yii cron
timeout /t 10 /nobreak > NUL
goto loop