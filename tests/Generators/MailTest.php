<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class MailTest extends TestCase
{
    protected $files = [
        'app/Mail/FooMail.php',
        'resources/views/foo-mail.blade.php',
        'tests/Feature/Mail/FooMailTest.php',
    ];

    /** @test */
    public function it_can_generate_mail_file()
    {
        $this->artisan('make:mail', ['name' => 'FooMail'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Mail;',
            'use Illuminate\Mail\Mailable;',
            'class FooMail extends Mailable',
        ], 'app/Mail/FooMail.php');

        $this->assertFilenameNotExists('resources/views/foo-mail.blade.php');
        $this->assertFilenameNotExists('tests/Feature/Mail/FooMailTest.php');
    }

    /** @test */
    public function it_can_generate_mail_with_markdown_options_file()
    {
        $this->artisan('make:mail', ['name' => 'FooMail', '--markdown' => 'foo-mail'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Mail;',
            'use Illuminate\Mail\Mailable;',
            'class FooMail extends Mailable',
            'return new Content(',
            "markdown: 'foo-mail',",
        ], 'app/Mail/FooMail.php');

        $this->assertFileContains([
            '<x-mail::message>',
            '<x-mail::button :url="\'\'">',
            '</x-mail::button>',
            '</x-mail::message>',
        ], 'resources/views/foo-mail.blade.php');
    }

    /** @test */
    public function it_can_generate_mail_file_with_tests()
    {
        $this->artisan('make:mail', ['name' => 'FooMail', '--test' => true])
            ->assertExitCode(0);

        $this->assertFilenameExists('app/Mail/FooMail.php');
        $this->assertFilenameNotExists('resources/views/foo-mail.blade.php');
        $this->assertFilenameExists('tests/Feature/Mail/FooMailTest.php');
    }
}