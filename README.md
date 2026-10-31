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
| `--accent-ring` | `rgba(167, 139, 250, 0.70)` | Focus rings (≥3:1 non-text on every adjacency) |
| `--accent-text` | `#a78bfa` | Accent color as foreground text/icon (AA ≥4.5:1 on bg/surface) |

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
| `--text-subtle` | `#978aa3` | Tertiary text (AA ≥4.5:1 on every surface) |
| `--text-faint` | `#7c6f87` | Disabled/hint text (≥3:1 on every surface) |
| `--text-on-accent` | `#0f0d14` | Dark ink on accent fill (AA ≥4.5:1 on all accent fills) |

#### On-accent ink duality (known limitation)

`--text-on-accent` governs only the ~10 accent-fill sites a theme owns.
Other on-accent labels — the MediaCard NEW badge and ~25 further sites —
are painted with the host's structural `--accent-contrast` (`#2a1804`,
warm), which is not in the theme-overridable token allowlist, so no
plugin theme can retint it. A violet fill therefore carries two
near-blacks, warm and cool, side by side. Both instantiated pairings pass
AA: 6.27:1 / 9.24:1 for the structural ink on `--accent` /
`--accent-hover`, and 7.09:1 / 10.46:1 / 4.56:1 for this theme's ink —
the last on the pressed `--accent-active`, a documented thin margin.

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
| `--vignette` | `rgba(139, 92, 246, 0.25)` | Edge tint — a violet wash that composites lighter over `--bg` (not a darkening) |
| `--ambient` | `rgba(167, 139, 250, 0.18)` | Ambient glow |

## Requirements

- PHP >= 8.3
- Phlix Server >= 0.44.0

## Installation

The server installs plugins from the **catalog** (`plugins.json`): a release
entry pins an exact commit (`ref`) and the sha256 of its tarball
(`artifactSha256`), and the loader verifies those bytes before extracting
anything — without a pin `PluginLoader::install()` refuses outright.

**Admin UI** — *Admin → Plugins*, find **Phantom Violet Theme**, press
**Install**, then flip its switch: a fresh install lands **disabled**
(`phlix-docs/docs/plugins/install-from-catalog.md`).

**CLI** — from the server root, pass the repository **URL**, not the bare name
(only the URL is rewritten to the pinned archive):

```bash
php bin/phlix plugin:install https://github.com/detain/phlix-plugin-phantom-violet-theme
php bin/phlix plugin:enable  phlix-plugin-phantom-violet-theme
php bin/phlix plugin:list
```

**Then pick it** — enabling registers `phantom-violet` as a theme source and a
`ui-theme` applies immediately on enable; *Settings → Appearance* then shows
the Phantom Violet swatch. If the swatch is missing, `plugin:list` tells you
whether the plugin is installed-but-disabled or was never registered.

`composer require` in the server root is **not** an install route: the loader
unpacks catalog artifacts into `var/plugins/phlix-plugin-phantom-violet-theme/`
(manifest `name`) with a per-plugin vendor and writes the `plugins` table — a
root-level composer require does none of that, and the theme never appears.

## Development

```bash
# Install dependencies
composer install

# Run PHPUnit tests
vendor/bin/phpunit

# Run PHPStan static analysis
composer phpstan

# Run PHPCS code style check
composer phpcs
```

## License

MIT License - see [LICENSE](LICENSE) for details.
