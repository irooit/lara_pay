@echo off

rem -------------------------------------------------------------
rem  Laravel command line bootstrap script for Windows.
rem
rem  @author Tongle Xu <xutongle@gmail.com>
rem  @link http://www.l68.net/
rem -------------------------------------------------------------

@setlocal

set LARAVEL_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%LARAVEL_PATH%artisan" %*

@endlocal
