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
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/controller.api.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/controller.api.stub
awk '{sub(/use DummyRootNamespaceHttp/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/controller.invokable.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/controller.invokable.stub
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/controller.model.api.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/controller.model.api.stub
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/controller.model.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/controller.model.stub
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/controller.nested.api.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/controller.nested.api.stub
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/controller.nested.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/controller.nested.stub
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/controller.plain.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/controller.plain.stub
awk '{sub(/use {{ rootNamespace }}Http/,"use {{ rootNamespace }}\\Http")}1' storage/laravel/controller.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/controller.stub

## Fixes namespace.
awk '{sub(/use PHPUnit\\Framework\\TestCase/,"use NamespacedDummyTestCase")}1' storage/laravel/test.unit.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/test.unit.stub
awk '{sub(/class {{ class }} extends TestCase/,"class {{ class }} extends DummyTestCase")}1' storage/laravel/test.unit.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/test.unit.stub
awk '{sub(/use Tests\\TestCase/,"use NamespacedDummyTestCase")}1' storage/laravel/test.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/test.stub
awk '{sub(/class {{ class }} extends TestCase/,"class {{ class }} extends DummyTestCase")}1' storage/laravel/test.stub > storage/laravel/temp.stub && mv storage/laravel/temp.stub storage/laravel/test.stub
