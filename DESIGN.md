# Design direction

Transcribed from what the code already does (`resources/css/app.css`, `Welcome.vue`, the shared
components), not invented. Where the code decided something, this file records it. Change the code
and this file together.

## Identity

A companion for a physical board game, used at the table between turns. It should feel like part of
the Monster Hunter World board game box, not like a generic SaaS dashboard: the two themes are taken
from the game's own materials.

- **Light is Iceborne.** Hoarfrost Reach: pale blue and white surfaces, navy panels, cyan ornament.
  The gray ramp is cool rather than neutral.
- **Dark is the base game's components.** Near black cards with brass emblems, parchment for the
  physiology and time cards, and the yellow line across every attack card. The gray ramp is warm.

The theme is the visitor's choice (`ButtonDark.vue`), and both have to work.

## Palette

One primary ramp per theme, redefined under `.dark`, so the markup never needs a second class:

- Light primary: cyan blue (`--color-primary-500` `#1a9ddc`).
- Dark primary: brass (`--color-primary-500` `#d69a1e`).
- Grays: cool in light, warm in dark.
- Game tokens with a fixed meaning, used only where the game uses them: the five elements (fire,
  water, ice, thunder, dragon), parchment, the attack line, and bronze, silver and gold for rarity.

Secondary text uses gray 700 in light and gray 300 in dark. Gray 500 does not reach 4.5:1 on either
background.

## Typography

- Headings (`h1` to `h3`): Montserrat, weight 700, tracking `-0.02em`.
- Body: Nunito.
- Uppercase with wide tracking only on buttons (`PrimaryButton`), where it reads as a control.

## Shape and motif

- Small radii (1 to 8 px). Panels read as cards from the game, not pills; `rounded-full` is kept
  for avatars and stat circles only.
- **The identity motif is the notched corner**: `mh-frame` (a border plus two corner marks) and
  `mh-notch` (the marks alone, for buttons and values). It is what makes a panel look like it came
  out of the box.
- Section titles on the public page carry a short primary line under them.

## Dials

ENERGY 1 / RHYTHM 2 / MOTION 1.

A calm tool for use mid game, so no animation beyond hover and focus states. Sections on the public
page vary in composition (screenshot beside text, a text only band) without breaking the shared
heading style.

## Imagery

- Real screenshots of the app, in the page's language, framed with `mh-frame`.
- The hero uses stills from Capcom's video game. That is the owner's decision, recorded in CLAUDE.md
  under "The public page".
- No portraits or illustrations reproduced from Steamforged's board game art.
