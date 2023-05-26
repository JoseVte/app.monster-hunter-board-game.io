# Monster Hunter Board Game (web app helper)

[![JoseVte - app.monster-hunter-board-game.io](https://img.shields.io/static/v1?label=JoseVte&message=app.monster-hunter-board-game.io&color=blue&logo=github)](https://github.com/JoseVte/app.monster-hunter-board-game.io "Go to GitHub repo")
[![stars - app.monster-hunter-board-game.io](https://img.shields.io/github/stars/JoseVte/app.monster-hunter-board-game.io?style=social)](https://github.com/JoseVte/app.monster-hunter-board-game.io)
[![forks - app.monster-hunter-board-game.io](https://img.shields.io/github/forks/JoseVte/app.monster-hunter-board-game.io?style=social)](https://github.com/JoseVte/app.monster-hunter-board-game.io)

[![Made with Node.js](https://img.shields.io/badge/10-FF2D20?logo=laravel&logoColor=white)](https://laravel.com "Go to Laravel homepage")
[![Made with Node.js](https://img.shields.io/badge/8.2-777BB4?logo=php&logoColor=white)](https://php.net "Go to PHP homepage")
[![Made with Node.js](https://img.shields.io/badge/>=16-339933?logo=node.js&logoColor=white)](https://nodejs.org "Go to Node.js homepage")
[![Made with Vue](https://img.shields.io/badge/3-4FC08D?logo=vue.js&logoColor=white)](https://v3.vuejs.org "Go to Vue homepage")

[![Laravel](https://github.com/JoseVte/app.monster-hunter-board-game.io/workflows/Laravel/badge.svg)](https://github.com/JoseVte/app.monster-hunter-board-game.io/actions?query=workflow:"Laravel")
[![GitHub tag](https://img.shields.io/github/tag/JoseVte/app.monster-hunter-board-game.io?include_prereleases=&sort=semver&color=blue)](https://github.com/JoseVte/app.monster-hunter-board-game.io/releases/)
[![License](https://img.shields.io/badge/License-MIT-blue)](https://github.com/JoseVte/app.monster-hunter-board-game.io/LICENSE.txt)
[![issues - app.monster-hunter-board-game.io](https://img.shields.io/github/issues/JoseVte/app.monster-hunter-board-game.io)](https://github.com/JoseVte/app.monster-hunter-board-game.io/issues)

This is Laravel web to help to manage the campaigns for [Monster Hunter Board Game](https://steamforged.com/en-eu/products/monster-hunter-world-the-board-game)

## Local Development

This project uses [Laravel Sail](https://laravel.com/docs/sail) to manage its local development stack. For more detailed usage instructions take a look at the [official documentation](https://laravel.com/docs/sail).

### Links

- **Your Application** http://localhost
- **Preview Emails via Mailpit** http://localhost:8025
- **MeiliSearch Administration Panel** http://localhost:7700
- **MinIO Administration Panel** http://localhost:9000
- **Laravel Horizon** http://localhost/horizon

### Start the development server

```shell
./vendor/bin/sail up
```

You can also use the `-d` option, to start the server in
the background if you do not care about the logs or still want to use your
terminal for other things.

### Build frontend assets

```shell
./vendor/bin/sail npm dev
```

### Run Tests

```shell
./vendor/bin/sail test
```
