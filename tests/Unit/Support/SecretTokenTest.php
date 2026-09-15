<?php

declare(strict_types=1);

namespace Componist\Core\Tests\Unit\Support;

use Componist\Core\Support\SecretToken;
use Tests\TestCase;

class SecretTokenTest extends TestCase
{
    public function test_hash_is_sha256_hex_and_equals_uses_hash_equals(): void
    {
        $plain = 'secret-token-value';
        $hash = SecretToken::hash($plain);

        $this->assertTrue(SecretToken::isHashed($hash));
        $this->assertTrue(SecretToken::equals($plain, $hash));
        $this->assertFalse(SecretToken::equals('other', $hash));
    }

    public function test_equals_accepts_legacy_plaintext(): void
    {
        $this->assertTrue(SecretToken::equals('plain', 'plain'));
        $this->assertFalse(SecretToken::equals('plain', 'other'));
    }

    public function test_hash_if_plain_does_not_rehash(): void
    {
        $hash = SecretToken::hash('once');

        $this->assertSame($hash, SecretToken::hashIfPlain($hash));
        $this->assertSame($hash, SecretToken::hashIfPlain('once'));
    }
}
