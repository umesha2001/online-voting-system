@echo off
echo ========================================
echo  Online Voting System - Quick Test
echo ========================================
echo.

REM Check if MySQL is running
echo [1/2] Checking MySQL connection...
C:\xampp\php\php.exe -r "$conn = @mysqli_connect('localhost', 'root', ''); if($conn) { echo 'MySQL is running - OK\n'; mysqli_close($conn); } else { echo 'ERROR: MySQL is not running! Please start MySQL in XAMPP.\n'; exit(1); }"
if %errorlevel% neq 0 (
    echo.
    echo Please start MySQL from XAMPP Control Panel
    pause
    exit /b 1
)

echo.
echo [2/2] Running tests...
echo.
C:\xampp\php\php.exe manual-test.php

echo.
echo ========================================
echo  Testing Complete!
echo ========================================
pause
