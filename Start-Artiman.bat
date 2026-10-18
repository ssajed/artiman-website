@echo off
title Artiman Sanat - Laravel Server
cd /d "C:\laragon\www\artiman-website"

"C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64\php.exe" artisan serve --host=127.0.0.1 --port=8080

pause
