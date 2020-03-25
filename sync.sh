#!/bin/bash

# Database
cp -rf vendor/laravel/framework/src/Illuminate/Database/Console/Factories/stubs/*.stub storage/laravel/database/factories/
cp -rf vendor/laravel/framework/src/Illuminate/Database/Migrations/stubs/*.stub storage/laravel/database/migrations/
cp -rf vendor/laravel/framework/src/Illuminate/Database/Console/Seeds/stubs/*.stub storage/laravel/database/seeds/

# Foundation
cp -rf vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/*.stub storage/laravel/
rm -rf storage/laravel/routes.stub

## Eloquent
rm -rf storage/laravel/database/eloquent/*.stub
mv storage/laravel/model.stub storage/laravel/database/eloquent/model.stub
mv storage/laravel/model.pivot.stub storage/laravel/database/eloquent/model.pivot.stub
mv storage/laravel/observer.plain.stub storage/laravel/database/eloquent/observer.plain.stub
mv storage/laravel/observer.stub storage/laravel/database/eloquent/observer.stub

# Routing
cp -rf vendor/laravel/framework/src/Illuminate/Routing/Console/stubs/*.stub storage/laravel/routing/

## Fixes namespace.
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/routing/controller.api.stub > storage/laravel/routing/temp.stub && mv storage/laravel/routing/temp.stub storage/laravel/routing/controller.api.stub
awk '{sub(/use DummyRootNamespaceHttp/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/routing/controller.invokable.stub > storage/laravel/routing/temp.stub && mv storage/laravel/routing/temp.stub storage/laravel/routing/controller.invokable.stub
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/routing/controller.model.api.stub > storage/laravel/routing/temp.stub && mv storage/laravel/routing/temp.stub storage/laravel/routing/controller.model.api.stub
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/routing/controller.model.stub > storage/laravel/routing/temp.stub && mv storage/laravel/routing/temp.stub storage/laravel/routing/controller.model.stub
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/routing/controller.nested.api.stub > storage/laravel/routing/temp.stub && mv storage/laravel/routing/temp.stub storage/laravel/routing/controller.nested.api.stub
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/routing/controller.nested.stub > storage/laravel/routing/temp.stub && mv storage/laravel/routing/temp.stub storage/laravel/routing/controller.nested.stub
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/routing/controller.plain.stub > storage/laravel/routing/temp.stub && mv storage/laravel/routing/temp.stub storage/laravel/routing/controller.plain.stub
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/routing/controller.stub > storage/laravel/routing/temp.stub && mv storage/laravel/routing/temp.stub storage/laravel/routing/controller.stub

## Fixes namespace.
awk '{sub(/use PHPUnit\\Framework\\TestCase/,"use NamespacedDummyTestCase")}1' storage/laravel/test.unit.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/test.unit.stub
awk '{sub(/class {{ class }} extends TestCase/,"class {{ class }} extends DummyTestCase")}1' storage/laravel/test.unit.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/test.unit.stub
awk '{sub(/use Tests\\TestCase/,"use NamespacedDummyTestCase")}1' storage/laravel/test.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/test.stub
awk '{sub(/class {{ class }} extends TestCase/,"class {{ class }} extends DummyTestCase")}1' storage/laravel/test.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/test.stub
