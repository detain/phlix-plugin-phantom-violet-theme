<?php

/**
 * Contrast contract law for the shipped Phantom Violet token palette.
 *
 * The token contract (phlix-tokens src/css/colors.css, consumed by the host
 * through applyThemeTokens) assigns each text role a WCAG floor, measured on
 * the grounds it is actually painted on. Values are parsed from
 * providedThemes() so the law follows the palette — it is not a duplicated
 * constant table, and the WCAG 1.4.3 math is recomputed here from the hexes
 * themselves (no external fixture to drift).
 *
 * @copyright 2026 Joe Huss <detain@interserver.net>
 * @license   MIT
 */

declare(strict_types=1);

namespace Phlix\PhantomViolet\Tests;

use Phlix\PhantomViolet\PhantomVioletPlugin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use RuntimeException;

#[CoversClass(PhantomVioletPlugin::class)]
final class TokenContrastTest extends TestCase
{
    /** WCAG 1.4.3 AA floor for normal-size text. */
    private const AA_TEXT_RATIO = 4.5;

    /** WCAG 1.4.11 floor for non-text UI components and hint-tier inks. */
    private const NON_TEXT_RATIO = 3.0;

    private PhantomVioletPlugin $plugin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->plugin = new PhantomVioletPlugin();
    }

    /**
     * One shipped token value, parsed at the boundary and guaranteed string.
     */
    private function token(string $key): string
    {
        $themes = $this->plugin->providedThemes();
        $this->assertNotEmpty($themes, 'Plugin must provide at least one theme');
        $tokens = $themes[0]['tokens'];
        $this->assertIsArray($tokens, 'Theme must carry a tokens array');
        $value = $tokens[$key] ?? null;
        $this->assertIsString($value, "Token {$key} must be a literal string value");

        return $value;
    }

    /**
     * @return array<string, string>
     */
    private function grounds(): array
    {
        $grounds = [];
        foreach (['--bg', '--surface', '--surface-2', '--surface-3'] as $key) {
            $grounds[$key] = $this->token($key);
        }

        return $grounds;
    }

    #[Test]
    public function testTextSubtleMeetsAaAsPlaceholderBodyTierOnEveryGround(): void
    {
        $ink = $this->token('--text-subtle');

        foreach ($this->grounds() as $name => $ground) {
            $ratio = $this->contrastRatio($ink, $ground);
            $this->assertGreaterThanOrEqual(
                self::AA_TEXT_RATIO,
                $ratio,
                sprintf(
                    '--text-subtle %s on %s (%s) is %.2f:1 — below the 4.5:1 AA floor',
                    $ink,
                    $name,
                    $ground,
                    $ratio
                )
            );
        }
    }

    #[Test]
    public function testTextFaintClearsTheNonTextMinimumAsHintTierOnEveryGround(): void
    {
        $ink = $this->token('--text-faint');

        foreach ($this->grounds() as $name => $ground) {
            $ratio = $this->contrastRatio($ink, $ground);
            $this->assertGreaterThanOrEqual(
                self::NON_TEXT_RATIO,
                $ratio,
                sprintf(
                    '--text-faint %s on %s (%s) is %.2f:1 — below the 3:1 placeholder/hint minimum',
                    $ink,
                    $name,
                    $ground,
                    $ratio
                )
            );
        }
    }

    #[Test]
    public function testRampKeepsFaintBelowSubtleBelowMutedOnEveryGround(): void
    {
        $faint = $this->token('--text-faint');
        $subtle = $this->token('--text-subtle');
        $muted = $this->token('--text-muted');

        foreach ($this->grounds() as $name => $ground) {
            $this->assertLessThan(
                $this->contrastRatio($subtle, $ground),
                $this->contrastRatio($faint, $ground),
                "--text-faint must stay dimmer than --text-subtle on {$name}"
            );
            $this->assertLessThan(
                $this->contrastRatio($muted, $ground),
                $this->contrastRatio($subtle, $ground),
                "--text-subtle must stay dimmer than --text-muted on {$name}"
            );
        }
    }

    #[Test]
    public function testAccentRingMeetsNonTextMinimumUnderEveryAdjacency(): void
    {
        $ring = $this->parseRgba($this->token('--accent-ring'));

        $grounds = [];
        foreach ($this->grounds() as $name => $hex) {
            $grounds[$name] = $this->parseHex($hex);
        }

        foreach ($grounds as $onName => $paintedOn) {
            $painted = $this->compositeOver($ring, $paintedOn);
            foreach ($grounds as $adjName => $adjacent) {
                $ratio = $this->contrastRatioRgb($painted, $adjacent);
                $this->assertGreaterThanOrEqual(
                    self::NON_TEXT_RATIO,
                    $ratio,
                    sprintf(
                        '--accent-ring painted on %s is %s vs adjacent %s: %.2f:1 — below the 3:1 non-text minimum',
                        $onName,
                        $this->toHex($painted),
                        $adjName,
                        $ratio
                    )
                );
            }
        }
    }

    #[Test]
    public function testAccentTextIsTheAccentColorItself(): void
    {
        $this->assertSame(
            $this->token('--accent'),
            $this->token('--accent-text'),
            'Contract (phlix-tokens src/css/colors.css): --accent-text is the accent '
            . 'color AS foreground text/icon — the ink-on-fill role is --text-on-accent'
        );
    }

    #[Test]
    public function testAccentTextMeetsAaAsForegroundOnEveryGround(): void
    {
        $ink = $this->token('--accent-text');

        foreach ($this->grounds() as $name => $ground) {
            $ratio = $this->contrastRatio($ink, $ground);
            $this->assertGreaterThanOrEqual(
                self::AA_TEXT_RATIO,
                $ratio,
                sprintf(
                    '--accent-text %s on %s (%s) is %.2f:1 — below the 4.5:1 AA foreground floor',
                    $ink,
                    $name,
                    $ground,
                    $ratio
                )
            );
        }
    }

    #[Test]
    public function testTextOnAccentMeetsAaAsInkOnEveryAccentFill(): void
    {
        $ink = $this->token('--text-on-accent');

        foreach (['--accent', '--accent-hover', '--accent-active'] as $fill) {
            $ratio = $this->contrastRatio($ink, $this->token($fill));
            $this->assertGreaterThanOrEqual(
                self::AA_TEXT_RATIO,
                $ratio,
                sprintf(
                    '--text-on-accent %s on %s is %.2f:1 — below the 4.5:1 AA floor',
                    $ink,
                    $fill,
                    $ratio
                )
            );
        }
    }

    /**
     * @return array{int, int, int, float}
     */
    private function parseRgba(string $value): array
    {
        $matches = [];
        if (
            preg_match('/^rgba\((\d{1,3}), (\d{1,3}), (\d{1,3}), (0?\.\d+|1|0)\)$/', $value, $matches)
            !== 1
        ) {
            throw new RuntimeException("Contrast law expects literal rgba(r, g, b, a), got '$value'");
        }

        return [
            (int) $matches[1],
            (int) $matches[2],
            (int) $matches[3],
            (float) $matches[4],
        ];
    }

    /**
     * 8-bit source-over compositing of an rgba token onto an opaque ground.
     *
     * @param array{int, int, int, float} $rgba
     * @param array{int, int, int}        $ground
     *
     * @return array{int, int, int}
     */
    private function compositeOver(array $rgba, array $ground): array
    {
        [$r, $g, $b, $alpha] = $rgba;

        return [
            (int) round($alpha * $r + (1 - $alpha) * $ground[0]),
            (int) round($alpha * $g + (1 - $alpha) * $ground[1]),
            (int) round($alpha * $b + (1 - $alpha) * $ground[2]),
        ];
    }

    /**
     * @param array{int, int, int} $rgb
     */
    private function toHex(array $rgb): string
    {
        return sprintf('#%02x%02x%02x', $rgb[0], $rgb[1], $rgb[2]);
    }

    /**
     * @param array{int, int, int} $rgbA
     * @param array{int, int, int} $rgbB
     */
    private function contrastRatioRgb(array $rgbA, array $rgbB): float
    {
        $luminanceA = $this->relativeLuminance($rgbA);
        $luminanceB = $this->relativeLuminance($rgbB);
        $brighter = max($luminanceA, $luminanceB);
        $darker = min($luminanceA, $luminanceB);

        return ($brighter + 0.05) / ($darker + 0.05);
    }

    /**
     * @return array{int, int, int}
     */
    private function parseHex(string $hex): array
    {
        $matches = [];
        if (preg_match('/^#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/', $hex, $matches) !== 1) {
            throw new RuntimeException("Contrast law expects literal #rrggbb, got '$hex'");
        }

        return [
            (int) hexdec($matches[1]),
            (int) hexdec($matches[2]),
            (int) hexdec($matches[3]),
        ];
    }

    /**
     * WCAG 2.x relative luminance of a #rrggbb hex.
     *
     * @param array{int, int, int} $rgb
     */
    private function relativeLuminance(array $rgb): float
    {
        $channels = [];
        foreach ($rgb as $channel) {
            $srgb = $channel / 255;
            $channels[] = $srgb <= 0.04045
                ? $srgb / 12.92
                : ((($srgb + 0.055) / 1.055) ** 2.4);
        }

        return 0.2126 * $channels[0] + 0.7152 * $channels[1] + 0.0722 * $channels[2];
    }

    private function contrastRatio(string $hexA, string $hexB): float
    {
        return $this->contrastRatioRgb($this->parseHex($hexA), $this->parseHex($hexB));
    }
}
