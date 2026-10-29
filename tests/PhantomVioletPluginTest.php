<?php

/**
 * Tests for the Phantom Violet ui-theme plugin.
 *
 * @copyright 2026 Joe Huss <detain@interserver.net>
 * @license   MIT
 */

declare(strict_types=1);

namespace Phlix\PhantomViolet\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\CoversClass;
use Phlix\PhantomViolet\PhantomVioletPlugin;

#[CoversClass(PhantomVioletPlugin::class)]
final class PhantomVioletPluginTest extends TestCase
{
    private PhantomVioletPlugin $plugin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->plugin = new PhantomVioletPlugin();
    }

    #[Test]
    public function testImplementsLifecycleInterface(): void
    {
        $this->assertInstanceOf(\Phlix\Shared\Plugin\LifecycleInterface::class, $this->plugin);
    }

    #[Test]
    public function testImplementsThemeSourceInterface(): void
    {
        $this->assertInstanceOf(\Phlix\Theming\ThemeSourceInterface::class, $this->plugin);
    }

    #[Test]
    public function testThemeSourceNameReturnsCorrectValue(): void
    {
        $this->assertSame('phantom-violet', $this->plugin->themeSourceName());
    }

    #[Test]
    public function testProvidedThemesReturnsExpectedStructure(): void
    {
        $themes = $this->plugin->providedThemes();

        $this->assertNotEmpty($themes, 'Plugin must provide at least one theme');

        $theme = $themes[0];
        $this->assertSame('phantom-violet', $theme['id']);
        $this->assertSame('Phantom Violet', $theme['name']);
        $this->assertTrue($theme['dark']);
        $this->assertSame('midnight', $theme['extends']);
        $this->assertArrayHasKey('tokens', $theme);
    }

    #[Test]
    public function testAllTokensAreValidCssValues(): void
    {
        $themes = $this->plugin->providedThemes();
        $theme = $themes[0];
        $tokens = $theme['tokens'];
        $this->assertIsArray($tokens, 'Theme must carry a tokens array');

        $forbidden = ['var(', 'url(', '/*', ';', '}', '{', '\\', "\n", "\t"];

        foreach ($tokens as $token => $value) {
            $this->assertIsString($value, "Token {$token} must have a string value");
            $this->assertNotEmpty($value, "Token {$token} must not be empty");

            foreach ($forbidden as $f) {
                $this->assertStringNotContainsString(
                    $f,
                    $value,
                    "Token {$token} contains forbidden CSS construct \"{$f}\""
                );
            }
        }
    }

    #[Test]
    public function testOnEnableDoesNotThrow(): void
    {
        $container = $this->createMock(\Psr\Container\ContainerInterface::class);

        $this->expectNotToPerformAssertions();
        $this->plugin->onEnable($container);
    }

    #[Test]
    public function testOnDisableDoesNotThrow(): void
    {
        $this->expectNotToPerformAssertions();
        $this->plugin->onDisable();
    }

    #[Test]
    public function testSubscribedEventsReturnsEmptyArray(): void
    {
        $events = $this->plugin->subscribedEvents();
        $this->assertEmpty($events);
    }
}
