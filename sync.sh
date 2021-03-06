#!/bin/bash

# Database
cp -rf vendor/laravel/framework/src/Illuminate/Database/Console/Factories/stubs/*.stub storage/laravel
cp -rf vendor/laravel/framework/src/Illuminate/Database/Migrations/stubs/*.stub storage/laravel
cp -rf vendor/laravel/framework/src/Illuminate/Database/Console/Seeds/stubs/*.stub storage/laravel

# Foundation
cp -rf vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/*.stub storage/laravel/
rm -rf storage/laravel/routes.stub

# Routing
cp -rf vendor/laravel/framework/src/Illuminate/Routing/Console/stubs/*.stub storage/laravel/

## Fixes namespace.
awk '{sub(/use PHPUnit\\Framework\\TestCase/,"use NamespacedDummyTestCase")}1' storage/laravel/test.unit.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/test.unit.stub
awk '{sub(/class {{ class }} extends TestCase/,"class {{ class }} extends DummyTestCase")}1' storage/laravel/test.unit.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/test.unit.stub
awk '{sub(/use Tests\\TestCase/,"use NamespacedDummyTestCase")}1' storage/laravel/test.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/test.stub
awk '{sub(/class {{ class }} extends TestCase/,"class {{ class }} extends DummyTestCase")}1' storage/laravel/test.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/test.stub
