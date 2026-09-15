<?php

declare(strict_types=1);

namespace Componist\Core\Support;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

final class PublicRemoteHost
{
    /**
     * @throws InvalidArgumentException
     */
    public static function assertPublicHttpUrl(string $url): string
    {
        $url = trim($url);
        $parts = parse_url($url);

        if ($parts === false || ! isset($parts['scheme'], $parts['host'])) {
            throw new InvalidArgumentException('Ungültige URL.');
        }

        $scheme = strtolower((string) $parts['scheme']);
        if (! in_array($scheme, ['http', 'https'], true)) {
            throw new InvalidArgumentException('Nur http- und https-URLs sind erlaubt.');
        }

        self::assertPublicHost((string) $parts['host']);

        return $url;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function assertPublicHost(string $host): string
    {
        $host = strtolower(trim($host));
        $host = trim($host, '[]');

        if ($host === '') {
            throw new InvalidArgumentException('Host ist erforderlich.');
        }

        if (in_array($host, ['localhost', '127.0.0.1', '0.0.0.0', '::1', '0'], true)) {
            throw new InvalidArgumentException('Lokale Hosts sind nicht erlaubt.');
        }

        if (str_ends_with($host, '.localhost') || str_ends_with($host, '.local') || str_ends_with($host, '.test')) {
            throw new InvalidArgumentException('Lokale Domains sind nicht erlaubt.');
        }

        $ip = self::coerceToIp($host);
        if ($ip !== null) {
            self::assertPublicIp($ip);

            return $host;
        }

        self::assertResolvedAddressesArePublic($host);

        return $host;
    }

    public static function client(?int $timeout = null): PendingRequest
    {
        return Http::timeout($timeout ?? 10)
            ->connectTimeout(5)
            ->withOptions([
                'allow_redirects' => false,
                'verify' => true,
            ]);
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertResolvedAddressesArePublic(string $host): void
    {
        $addresses = @gethostbynamel($host);
        if (! is_array($addresses) || $addresses === []) {
            throw new InvalidArgumentException('Host konnte nicht aufgelöst werden.');
        }

        foreach ($addresses as $address) {
            self::assertPublicIp($address);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function assertPublicIp(string $ip): void
    {
        $ip = strtolower(trim($ip, '[]'));

        if (str_starts_with($ip, '::ffff:')) {
            $ip = substr($ip, 7);
        }

        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            throw new InvalidArgumentException('Ungültige IP-Adresse.');
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            throw new InvalidArgumentException('Private oder reservierte IP-Adressen sind nicht erlaubt.');
        }
    }

    private static function coerceToIp(string $host): ?string
    {
        if (filter_var($host, FILTER_VALIDATE_IP) !== false) {
            return $host;
        }

        if (ctype_digit($host)) {
            $long = (int) $host;
            if ($long >= 0 && $long <= 4294967295) {
                return long2ip($long);
            }
        }

        if (preg_match('/^0x[0-9a-f]+$/i', $host) === 1) {
            return long2ip((int) hexdec(substr($host, 2)));
        }

        if (preg_match('/^[0-9.]+$/', $host) === 1) {
            $long = ip2long($host);
            if ($long !== false) {
                return long2ip($long);
            }
        }

        return null;
    }
}
