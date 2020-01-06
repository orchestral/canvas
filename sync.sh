#!/bin/bash

# Database
cp -rf vendor/laravel/framework/src/Illuminate/Database/Console/Factories/stubs/*.stub storage/database/factories/
cp -rf vendor/laravel/framework/src/Illuminate/Database/Migrations/stubs/*.stub storage/database/migrations/
cp -rf vendor/laravel/framework/src/Illuminate/Database/Console/Seeds/stubs/*.stub storage/database/seeds/

# Foundation
cp -rf vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/*.stub storage/laravel/
rm -rf storage/laravel/routes.stub

## Eloquent
rm -rf storage/database/eloquent/*.stub
mv storage/laravel/model.stub storage/database/eloquent/model.stub
mv storage/laravel/observer.plain.stub storage/database/eloquent/observer.plain.stub
mv storage/laravel/observer.stub storage/database/eloquent/observer.stub
mv storage/laravel/pivot.model.stub storage/database/eloquent/pivot.model.stub

## Event
rm -rf storage/event/*.stub
mv storage/laravel/event.stub storage/event/event.stub

## Exception
rm -rf storage/exception/*.stub
mv storage/laravel/exception-render-report.stub storage/exception/render-and-report.stub
mv storage/laravel/exception-render.stub storage/exception/render.stub
mv storage/laravel/exception-report.stub storage/exception/report.stub
mv storage/laravel/exception.stub storage/exception/exception.stub

## Job
rm -rf storage/job/*.stub
mv storage/laravel/job-queued.stub storage/job/queued.stub
mv storage/laravel/job.stub storage/job/job.stub

## Listener
rm -rf storage/listener/*.stub
mv storage/laravel/listener-queued-duck.stub storage/listener/queued-duck.stub
mv storage/laravel/listener-queued.stub storage/listener/queued.stub
mv storage/laravel/listener-duck.stub storage/listener/listener-duck.stub
mv storage/laravel/listener.stub storage/listener/listener.stub

## Mail
rm -rf storage/mail/*.stub
mv storage/laravel/markdown-mail.stub storage/mail/markdown.stub
mv storage/laravel/mail.stub storage/mail/mail.stub

## Notification
rm -rf storage/notification/*.stub
mv storage/laravel/markdown-notification.stub storage/notification/markdown.stub
mv storage/laravel/notification.stub storage/notification/notification.stub

## Policy
rm -rf storage/policy/*.stub
mv storage/laravel/policy.stub storage/policy/policy.stub
mv storage/laravel/policy.plain.stub storage/policy/plain.stub

## Provider
mv storage/laravel/provider.stub storage/provider/provider.stub

## Resource
rm -rf storage/resource/*.stub
mv storage/laravel/resource-collection.stub storage/resource/collection.stub
mv storage/laravel/resource.stub storage/resource/resource.stub

## Testing
rm -f storage/testing/feature.stub
rm -f storage/testing/unit.stub
mv storage/laravel/test.stub storage/testing/feature.stub
mv storage/laravel/unit-test.stub storage/testing/unit.stub

# Routing
cp -rf vendor/laravel/framework/src/Illuminate/Routing/Console/stubs/*.stub storage/routing/

## Fixes namespace.
awk '{sub(/use DummyRootNamespaceHttp/,"use DummyRootNamespace\\Http")}1' storage/routing/controller.api.stub > storage/routing/temp.stub && mv storage/routing/temp.stub storage/routing/controller.api.stub
awk '{sub(/use DummyRootNamespaceHttp/,"use DummyRootNamespace\\Http")}1' storage/routing/controller.invokable.stub > storage/routing/temp.stub && mv storage/routing/temp.stub storage/routing/controller.invokable.stub
awk '{sub(/use DummyRootNamespaceHttp/,"use DummyRootNamespace\\Http")}1' storage/routing/controller.model.api.stub > storage/routing/temp.stub && mv storage/routing/temp.stub storage/routing/controller.model.api.stub
awk '{sub(/use DummyRootNamespaceHttp/,"use DummyRootNamespace\\Http")}1' storage/routing/controller.model.stub > storage/routing/temp.stub && mv storage/routing/temp.stub storage/routing/controller.model.stub
awk '{sub(/use DummyRootNamespaceHttp/,"use DummyRootNamespace\\Http")}1' storage/routing/controller.nested.api.stub > storage/routing/temp.stub && mv storage/routing/temp.stub storage/routing/controller.nested.api.stub
awk '{sub(/use DummyRootNamespaceHttp/,"use DummyRootNamespace\\Http")}1' storage/routing/controller.nested.stub > storage/routing/temp.stub && mv storage/routing/temp.stub storage/routing/controller.nested.stub
awk '{sub(/use DummyRootNamespaceHttp/,"use DummyRootNamespace\\Http")}1' storage/routing/controller.plain.stub > storage/routing/temp.stub && mv storage/routing/temp.stub storage/routing/controller.plain.stub
awk '{sub(/use DummyRootNamespaceHttp/,"use DummyRootNamespace\\Http")}1' storage/routing/controller.stub > storage/routing/temp.stub && mv storage/routing/temp.stub storage/routing/controller.stub


