# Phantom Violet Theme Plugin

A deep violet accent theme with rich purple atmosphere for Phlix.

## Theme Design

The Phantom Violet theme extends the built-in `midnight` base and contributes a single `phantom-violet` theme with a distinctive violet accent ramp, deep purple surfaces, and ambient violet glow effects.

### Color Palette

| Token | Hex | Usage |
|-------|-----|-------|
| `--accent` | `#a78bfa` | Primary violet accent |
| `--accent-hover` | `#c4b5fd` | Hover state |
| `--accent-active` | `#8b5cf6` | Active/pressed state |
| `--accent-soft` | `rgba(167, 139, 250, 0.12)` | Soft background |
| `--accent-ring` | `rgba(167, 139, 250, 0.45)` | Focus rings |
| `--accent-text` | `#1a1625` | Text on accent |

### Background & Surface

| Token | Hex | Usage |
|-------|-----|-------|
| `--bg` | `#08070d` | Page background |
| `--surface` | `#100e17` | Card/panel surfaces |
| `--surface-2` | `#1a1725` | Elevated surfaces |
| `--surface-3` | `#252234` | Highest elevation |
| `--surface-glass` | `rgba(16, 14, 23, 0.68)` | Glass effect |
| `--surface-glass-strong` | `rgba(8, 7, 13, 0.88)` | Strong glass |

### Text

| Token | Hex | Usage |
|-------|-----|-------|
| `--text` | `#e8e4f0` | Primary text |
| `--text-muted` | `#a8a0b8` | Secondary text |
| `--text-subtle` | `#6e6578` | Tertiary text |
| `--text-faint` | `#3d3548` | Disabled/hint text |
| `--text-on-accent` | `#0f0d14` | Text on accent |

### Borders

| Token | Hex | Usage |
|-------|-----|-------|
| `--border` | `#2a2438` | Default border |
| `--border-subtle` | `#1c1825` | Subtle border |
| `--border-strong` | `#3d3550` | Emphasized border |

### Atmosphere

| Token | Value | Usage |
|-------|-------|-------|
| `--grain-opacity` | `0.03` | Film grain overlay |
| `--vignette` | `rgba(139, 92, 246, 0.25)` | Edge darkening |
| `--ambient` | `rgba(167, 139, 250, 0.18)` | Ambient glow |

## Requirements

- PHP >= 8.3
- Phlix Server >= 0.44.0

## Installation

```bash
composer require detain/phlix-plugin-phantom-violet-theme
```

## Development

```bash
# Install dependencies
composer install

# Run PHPStan static analysis
composer phpstan

# Run PHPCS code style check
composer phpcs
```

## License

MIT License - see [LICENSE](LICENSE) for details.
