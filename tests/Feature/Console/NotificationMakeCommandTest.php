<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class NotificationMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Notifications/FooNotification.php',
        'resources/views/foo-notification.blade.php',
        'tests/Feature/Notifications/FooNotificationTest.php',
    ];

    /** @test */
    public function it_can_generate_notification_file()
    {
        $this->artisan('make:notification', ['name' => 'FooNotification', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Notifications;',
            'use Illuminate\Notifications\Notification;',
            'class FooNotification extends Notification',
            'return (new MailMessage)',
        ], 'app/Notifications/FooNotification.php');

        $this->assertFilenameNotExists('resources/views/foo-notification.blade.php');
        $this->assertFilenameNotExists('tests/Feature/Notifications/FooNotificationTest.php');
    }

    /** @test */
    public function it_can_generate_notification_with_markdown_options_file()
    {
        $this->artisan('make:notification', ['name' => 'FooNotification', '--markdown' => 'foo-notification', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Notifications;',
            'class FooNotification extends Notification',
            "return (new MailMessage)->markdown('foo-notification')",
        ], 'app/Notifications/FooNotification.php');

        $this->assertFileContains([
            '<x-mail::message>',
        ], 'resources/views/foo-notification.blade.php');
    }

    /** @test */
    public function it_can_generate_notification_file_with_tests()
    {
        $this->artisan('make:notification', ['name' => 'FooNotification', '--test' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFilenameExists('app/Notifications/FooNotification.php');
        $this->assertFilenameNotExists('resources/views/foo-notification.blade.php');
        $this->assertFilenameExists('tests/Feature/Notifications/FooNotificationTest.php');
    }
}
