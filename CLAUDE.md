# CLAUDE.md

Guidance for Claude Code (and other AI assistants) working in this repository.

## What this is

**php2html (Clever-Html-Engine)** is a PHP 8 library that builds HTML pages from PHP calls (`htm_Page_`, `htm_Card_`, `htm_Input`,
`htm_Table` ...). It is a single file, `php2html.lib.php`, with no build step and no package manager (Composer only to install).
The rest of the repository is demo pages, translations, optional modules and tools.

## Read this first

- **`php2html.api.md`** is the API reference: conventions, pitfalls, a minimal page, and every public function with its parameters.
  Read it instead of the library (about 8,400 lines and 520 KB). Use the line numbers in it to jump to the code.
- **`php2html.api.md` is generated.** After any change of a function signature or parameter comment, run
  `php tools/make_api_md.php`. Never edit the .md file by hand.

## Layout

| Path | What |
|---|---|
| `php2html.lib.php` | The library - the only file a project needs (plus `_trans.sys.json` for translations) |
| `p2h_audit.inc.php`, `p2h_trans.inc.php` | Optional modules: activity log, translations editor (`htm_TransEditor`) |
| `customLib.inc.php`, `customRules.inc.php` | The user's own functions (loaded when present) and table row rules (`htm_Table(list:[...])`) |
| `_trans.sys.json` | Translations: `language[].translation` maps the English text (without `@`) to the language |
| `Proj.demo/`, `Quick_Proj/`, `world/` | Demo and starter pages (`*.page.php`) - test changes here |
| `tools/` | `make_api_md.php` (API reference), `named_args.php` (upgrade helper for 1.7) |
| `latest/` | An **old copy (1.4.1)** kept for old links - do not edit, left out of the Composer package |
| `CHANGELOG.md` | Add every user-visible change under `## Unreleased` |

## Conventions in the library

- **Named arguments only** in calls, e.g. `htm_Card_(capt:'@Settings', clas:'cardW800')`. Parameter names are a fixed 4-character
  vocabulary (`labl capt hint icon name valu form acti wdth vhgh styl attr clas kind vrnt list plho rtrn` ...) - reuse them for new parameters.
- **Each parameter on its own line with its comment** - `tools/make_api_md.php` reads exactly this format:
  `$name = default,   # type: description` (more lines of a description: a line with only `#         text`).
  The comment line above a function is its description; `[Necessary basic element]` marks a core function.
- **`rtrn` is the last parameter** of every `htm_*` function, default `false` (echo); `rtrn:true` returns the HTML
  (`if ($rtrn) return p2h_capture(__FUNCTION__, get_defined_vars());`).
- **User-visible texts are English** and translated with `lang('@Text')`; add the Danish (`da`) text to `_trans.sys.json` for new texts.
- `'` for PHP strings, `"` for HTML attributes. Comments in English (some old ones are Danish).
- Version header on line 1 of each file - bump it with substantive changes. The library and the files it includes use **their own names**
  (`$DocVerFile`, `$DocRevFile`, `$DocIniFile` - the modules `$DocVerAudit`, `$DocVerTrans`): never set a page's `$DocVer`, `$DocRev`, `$DocFil` or `$©`.
  The library version is `P2H_VERSION`.
- The library starts the session and **rejects every POST without a valid CSRF token** when it is included (403) - keep it that way.

## Checking a change

There is no test suite - `php tools/check_pages.php` checks it all (lint, every demo page without PHP messages, the API reference)
and must say ALL OK before a commit. What it covers:
1. `php -l php2html.lib.php` (and every changed file).
2. Run a demo page: `php -S localhost:8000` in the repo, open `world/first.page.php` or a page in `Proj.demo/`, and check
   that the page has no PHP warnings or notices.
3. `php tools/make_api_md.php` when a signature or parameter comment changed.
4. A line in `CHANGELOG.md` under `## Unreleased`.

## Git and releases

- Work on **`master`**. Push **only `master`**: the branch `demo-matomo` holds tracking code that must never reach GitHub.
- **Never push, tag or publish a release without an explicit "go" from the owner.** Commits are made by EV-soft.
- The working copy uses CRLF (`core.autocrlf=true`); keep the line endings of the file you edit.
- Releases are made with the `gh` CLI (tag `vX.Y.Z` + GitHub release with the CHANGELOG section) - only after the go.
