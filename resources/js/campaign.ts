// The one rule the campaign forms check before they submit, kept out of both
// of them so there is a single statement of it on the client. The server has
// the binding one (`App\Rules\IncludesABaseGame`); this exists so a reader
// finds out before a round trip, not instead of it.

export type ExpansionOption = {key: string; label: string; base_game: boolean; extra_days: number};

// A campaign is played out of the Ancient Forest, the Wildspire Waste, or
// both. Which of the options are base games comes from the enum through the
// page's props rather than from a list of names written here, so adding a
// third one is a PHP change and nothing else.
export function hasBaseGame(options: Array<ExpansionOption>, selected: Array<string>): boolean {
    return options.some((option) => option.base_game && selected.includes(option.key));
}
