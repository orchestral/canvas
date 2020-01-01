#!/bin/bash

# Database
cp -rf vendor/laravel/framework/src/Illuminate/Database/Console/Factories/stubs/*.stub storage/database/factories/
cp -rf vendor/laravel/framework/src/Illuminate/Database/Migrations/stubs/*.stub storage/database/migrations/

# Foundation
cp -rf vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/*.stub storage/laravel/

# Routing
cp -rf vendor/laravel/framework/src/Illuminate/Routing/Console/stubs/*.stub storage/routing/
