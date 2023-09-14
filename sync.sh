#!/bin/bash

# Database
cp -rf vendor/laravel/framework/src/Illuminate/Database/Console/Factories/stubs/*.stub src/Console/stubs/
# cp -rf vendor/laravel/framework/src/Illuminate/Database/Migrations/stubs/*.stub storage/laravel
# cp -rf vendor/laravel/framework/src/Illuminate/Database/Console/Seeds/stubs/*.stub storage/laravel

# Foundation
cp -rf vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/pest.stub src/Console/stubs/
cp -rf vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/pest.unit.stub src/Console/stubs/
cp -rf vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/test.stub src/Console/stubs/
cp -rf vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/test.unit.stub src/Console/stubs/
cp -rf vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/view.stub src/Console/stubs/
cp -rf vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/view.test.stub src/Console/stubs/
# rm -rf storage/laravel/routes.stub

# Routing
# cp -rf vendor/laravel/framework/src/Illuminate/Routing/Console/stubs/*.stub storage/laravel/

# Testing
cp -rf vendor/laravel/framework/tests/Integration/Generators/*.php workbench/tests/

## Fixes namespace.
awk '{sub(/use PHPUnit\\Framework\\TestCase/,"use NamespacedDummyTestCase")}1' src/Console/stubs/test.unit.stub > src/Console/stubs/temp.stub && mv src/Console/stubs/temp.stub src/Console/stubs/test.unit.stub
awk '{sub(/class {{ class }} extends TestCase/,"class {{ class }} extends DummyTestCase")}1' src/Console/stubs/test.unit.stub > src/Console/stubs/temp.stub && mv src/Console/stubs/temp.stub src/Console/stubs/test.unit.stub
awk '{sub(/use Tests\\TestCase/,"use NamespacedDummyTestCase")}1' src/Console/stubs/test.stub > src/Console/stubs/temp.stub && mv src/Console/stubs/temp.stub src/Console/stubs/test.stub
awk '{sub(/class {{ class }} extends TestCase/,"class {{ class }} extends DummyTestCase")}1' src/Console/stubs/test.stub > src/Console/stubs/temp.stub && mv src/Console/stubs/temp.stub src/Console/stubs/test.stub
awk '{sub(/use Tests\\TestCase/,"use NamespacedDummyTestCase")}1' src/Console/stubs/view.test.stub > src/Console/stubs/temp.stub && mv src/Console/stubs/temp.stub src/Console/stubs/view.test.stub
awk '{sub(/class {{ class }} extends TestCase/,"class {{ class }} extends DummyTestCase")}1' src/Console/stubs/view.test.stub > src/Console/stubs/temp.stub && mv src/Console/stubs/temp.stub src/Console/stubs/view.test.stub
