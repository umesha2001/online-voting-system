@echo off
echo ========================================
echo  PHPUnit Test Runner
echo ========================================
echo.

REM Check if MySQL is running
echo [1/2] Checking MySQL...
C:\xampp\php\php.exe -r "$conn = @mysqli_connect('localhost', 'root', ''); if($conn) { echo 'MySQL: OK\n'; mysqli_close($conn); } else { echo 'ERROR: MySQL not running!\n'; exit(1); }"
if %errorlevel% neq 0 (
    echo Please start MySQL from XAMPP Control Panel
    pause
    exit /b 1
)

echo.
echo [2/2] Running PHPUnit tests...
echo.

C:\xampp\php\php.exe phpunit.phar --no-configuration tests

echo.
if %errorlevel% equ 0 (
    echo ========================================
    echo  ALL TESTS PASSED! ✓
    echo ========================================
) else (
    echo ========================================
    echo  SOME TESTS FAILED!
    echo ========================================
)

pause
