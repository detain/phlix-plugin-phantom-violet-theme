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

#### On-Acccent Ink Duality (Known Limitation)

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

### Legacy `--color-*` Aliases

Components that have not migrated to the modern token names still read the
old `--color-*` aliases, so the theme mirrors five of the twenty-two aliases
`midnight` declares: `--color-bg` (4 reads), `--color-surface` (11),
`--color-text` (2), `--color-text-muted` (7), `--color-border` (13) — a
`var(--color-…)` census over the shipped `phlix-ui` components finds live
readers for each, `--color-border` and `--color-surface` the busiest (read
counts measured 2026-11-06 at `phlix-ui` origin/master `eb9e991c`). The ship
set is deliberately not the consumed set: five further aliases have live SPA
readers and stay midnight's — see the inherited-families section below.
Every one of the five mirrors its modern counterpart 1:1, keeping
un-migrated surfaces inside the violet field:

| Token | Hex | Mirrors |
|-------|-----|---------|
| `--color-bg` | `#08070d` | `--bg` |
| `--color-surface` | `#100e17` | `--surface` |
| `--color-text` | `#e8e4f0` | `--text` |
| `--color-text-muted` | `#a8a0b8` | `--text-muted` |
| `--color-border` | `#2a2438` | `--border` |

#### Inherited `midnight` Families (Known Limitation)

The theme overrides the accent, surface, text, border and atmosphere ramps but
leaves the semantic states (`--error`/`--success`/`--warning`/`--info` plus
their `-bg` pairs) and every other `--color-*` alias to the `midnight` base,
so midnight's amber/brown hues sit inside the violet field. Measured against
*this* theme's grounds (recomputed on the shipped palette): `--error` 4.72:1
(thin AA margin on `--surface-3`), `--info` 5.95:1, `--success` 6.85:1,
`--warning` 7.18:1 — all AA text, but the warning amber and the violet accent
read as a similar-weight, different-hue pair (`L` 0.44 vs 0.34).

Consumers of the unset aliases, by the same `var()` census: five of the
seventeen have live readers in the shipped SPA. `--color-text-secondary`
(eight sites in `SyncPlayPage`, `ParentalControlsPage` and
`UpdateAvailableBanner`) resolves to midnight's warm `#a99d8c` (5.81:1 on
the worst violet ground) beside the theme's own cool `--text-muted`
`#a8a0b8`; and the four non-`-bg` state aliases read at five more sites —
`--color-error` twice in `ParentalControlsPage`, `--color-success`,
`--color-warning` and `--color-info` once each in `SyncPlayPage` — so
midnight's state hues are exposed in the SPA itself, not only on the wire;
they carry the identical values measured AA above. Only the remaining
twelve are truly unread in the SPA (`--color-primary/-hover/-active`,
`--color-surface-hover/-elevated/-active`, `--color-text-subtle`,
`--color-border-subtle` and the four `-bg` state pairs); their exposure is
on the wire as `midnight`'s OWN entry —
`GET /api/v1/themes` emits each theme's declared token map, not an
`extends`-flattened one: the `phantom-violet` entry carries the 28 tokens
above and none of these aliases, while `midnight` lists beside it with
`--color-surface-hover: #141009` (warm). The warm-against-violet pairing
(that `#141009` under this theme's `--surface-2: #1a1725`) therefore
materializes only in a client that performs the documented layering —
the server ships every base it knows in the same response, so the list is
self-sufficient for that, but deliberately never publishes a flattened view:
one theme, one source of truth.

The five live-reader counts above re-measure 2026-11-06 at the same `phlix-ui`
pin as the stamped set; `midnight`'s twenty-two-alias declaration and the
quoted wire hexes measure 2026-11-06 at `phlix-server` origin/master
`a63dc0db`.

Harmonizing these hues — setting the states and aliases in the shipped map —
is a token-value change deliberately left to the theme owner; this section
documents the seam rather than shipping the move.

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

MIT License — see [LICENSE](LICENSE) for details.
