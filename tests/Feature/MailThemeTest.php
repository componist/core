<?php

declare(strict_types=1);

namespace Componist\Core\Tests\Feature;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class MailThemeTest extends TestCase
{
    public function test_markdown_mail_uses_soft_split_theme(): void
    {
        Config::set('componist_mail.brand_name', 'Componist Test');
        Config::set('componist_mail.brand_tagline', 'SaaS Platform');
        Config::set('app.url', 'http://app.example.test');

        $html = (string) (new MailMessage)
            ->subject('Test')
            ->greeting('Hallo,')
            ->line('Dies ist eine Testnachricht.')
            ->action('Jetzt öffnen', 'http://app.example.test/dashboard')
            ->render();

        $this->assertStringContainsString('#14b8a6', $html);
        $this->assertStringContainsString('border-left: 4px solid #14b8a6', $html);
        $this->assertStringContainsString('Componist Test', $html);
        $this->assertStringContainsString('Jetzt öffnen', $html);
        $this->assertStringContainsString('Sie erhalten diese E-Mail, weil Sie ein Konto bei', $html);
    }

    public function test_mail_shell_matches_soft_split_structure(): void
    {
        Config::set('componist_mail.brand_name', 'Componist Test');
        Config::set('componist_mail.brand_tagline', 'SaaS Platform');
        Config::set('componist_mail.support_email', 'support@example.test');
        Config::set('app.url', 'http://app.example.test');

        $html = (string) $this->blade(
            <<<'BLADE'
            <x:component::mail.shell title="Passwort zurücksetzen" label="Sicherheit" preheader="Link 60 Minuten gültig">
                <x:component::mail.heading title="Passwort zurücksetzen" greeting="Hallo Anna," />
                <x:component::mail.sep />
                <x:component::mail.section>
                    <p>wir haben eine Anfrage erhalten.</p>
                </x:component::mail.section>
                <x:component::mail.sep />
                <x:component::mail.section padding="cta">
                    <x:component::mail.button url="http://app.example.test/reset">
                        Neues Passwort festlegen
                    </x:component::mail.button>
                </x:component::mail.section>
                <x:component::mail.section>
                    <x:component::mail.panel title="Sicherheitshinweis">
                        Falls Sie diese Anfrage nicht gestellt haben, können Sie diese E-Mail ignorieren.
                    </x:component::mail.panel>
                </x:component::mail.section>
            </x:component::mail.shell>
            BLADE
        );

        $this->assertStringContainsString('border-left:4px solid #14b8a6', $html);
        $this->assertStringContainsString('Componist Test', $html);
        $this->assertStringContainsString('SaaS Platform', $html);
        $this->assertStringContainsString('Sicherheit', $html);
        $this->assertStringContainsString('Passwort zurücksetzen', $html);
        $this->assertStringContainsString('Hallo Anna,', $html);
        $this->assertStringContainsString('Neues Passwort festlegen', $html);
        $this->assertStringContainsString('Sicherheitshinweis', $html);
        $this->assertStringContainsString('support@example.test', $html);
        $this->assertStringContainsString('Sie erhalten diese E-Mail, weil Sie ein Konto bei', $html);
        $this->assertStringContainsString('automatisch versendet', $html);
        $this->assertStringContainsString('Link 60 Minuten gültig', $html);
    }

    public function test_mail_code_component_renders_otp_panel(): void
    {
        $html = (string) $this->blade(
            '<x:component::mail.code code="SKEFMF8TKTKK" />'
        );

        $this->assertStringContainsString('SKEFMF8TKTKK', $html);
        $this->assertStringContainsString('#f0fdfa', $html);
        $this->assertStringContainsString('#0f766e', $html);
    }
}
