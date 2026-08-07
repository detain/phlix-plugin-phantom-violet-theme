<?php

/**
 * Phlix Phantom Violet plugin: a ui-theme provider.
 *
 * @copyright 2026 Joe Huss <detain@interserver.net>
 * @license   MIT
 */

declare(strict_types=1);

namespace Phlix\PhantomViolet;

use Phlix\Shared\Plugin\LifecycleInterface;
use Phlix\Theming\ThemeSourceInterface;
use Psr\Container\ContainerInterface;

/**
 * Phantom Violet — a deep violet accent theme with rich purple atmosphere.
 *
 * This theme extends the built-in `midnight` base and contributes a single
 * `phantom-violet` theme with a distinctive violet accent ramp, deep purple
 * surfaces, and ambient violet glow effects.
 *
 * ## Theme Design
 *
 * The Phantom Violet theme features:
 * - Soft violet accent (#a78bfa) with elegant hover/active states
 * - Deep, rich purple surfaces that create depth
 * - Ambient violet glow effects for atmosphere
 * - Subtle grain texture for visual interest
 * - Strong vignette effect for focus
 *
 * @package Phlix\PhantomViolet
 * @since 1.0.0
 */
final class PhantomVioletPlugin implements LifecycleInterface, ThemeSourceInterface
{
    /**
     * Canonical provenance key for this source.
     *
     * The host keys the registry's provenance map on this, so re-enabling
     * REPLACES this plugin's themes instead of duplicating them, and disabling
     * removes exactly this id. Keep it constant across versions.
     */
    public const SOURCE_NAME = 'phantom-violet';

    /**
     * Nothing to do — the host registers the themes off the `instanceof`.
     *
     * @param ContainerInterface $container The host container (unused).
     */
    public function onEnable(ContainerInterface $container): void
    {
    }

    /**
     * Nothing to do — the host deregisters this source by name on disable.
     */
    public function onDisable(): void
    {
    }

    /**
     * A theme plugin subscribes to no events.
     *
     * @return array<class-string, string> Always empty.
     */
    public function subscribedEvents(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function themeSourceName(): string
    {
        return self::SOURCE_NAME;
    }

    /**
     * @inheritDoc
     *
     * @return list<array<array-key, mixed>>
     */
    public function providedThemes(): array
    {
        return [
            [
                'id' => 'phantom-violet',
                'name' => 'Phantom Violet',
                'dark' => true,
                // A BUILT-IN base: only the SPA can resolve this one.
                'extends' => 'midnight',
                'tokens' => [
                    // Accent ramp — violet tones with elegant state transitions
                    '--accent' => '#a78bfa',
                    '--accent-hover' => '#c4b5fd',
                    '--accent-active' => '#8b5cf6',
                    '--accent-soft' => 'rgba(167, 139, 250, 0.12)',
                    '--accent-ring' => 'rgba(167, 139, 250, 0.45)',
                    '--accent-text' => '#f5f3ff',

                    // Background + elevation stack — deep purple blacks
                    '--bg' => '#08070d',
                    '--surface' => '#100e17',
                    '--surface-2' => '#1a1725',
                    '--surface-3' => '#252234',
                    '--surface-glass' => 'rgba(16, 14, 23, 0.68)',
                    '--surface-glass-strong' => 'rgba(8, 7, 13, 0.88)',

                    // Text ramp — cool lavender whites
                    '--text' => '#e8e4f0',
                    '--text-muted' => '#a8a0b8',
                    '--text-subtle' => '#6e6578',
                    '--text-faint' => '#3d3548',
                    '--text-on-accent' => '#0f0d14',

                    // Borders — subtle purple-tinted
                    '--border' => '#2a2438',
                    '--border-subtle' => '#1c1825',
                    '--border-strong' => '#3d3550',

                    // Atmosphere — grain, vignette, ambient glow
                    '--grain-opacity' => '0.03',
                    '--vignette' => 'rgba(139, 92, 246, 0.25)',
                    '--ambient' => 'rgba(167, 139, 250, 0.18)',

                    // Legacy `--color-*` aliases — only the ones the shipped SPA still reads
                    '--color-bg' => '#08070d',
                    '--color-surface' => '#100e17',
                    '--color-text' => '#e8e4f0',
                    '--color-text-muted' => '#a8a0b8',
                    '--color-border' => '#2a2438',
                ],
            ],
        ];
    }
}