@echo off
echo Starting Laravel development server...
start cmd /k "php artisan serve"
timeout /t 2 /nobreak > nul
echo Starting Vite development server...
echo Visit http://localhost:8000 for the application
node node_modules/vite/bin/vite.js
