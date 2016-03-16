# Gitlab issues + Trello

## About

It's a simple script for adding cards to Trello based on issues in gitlab project

## Content

* [Installation](#installation)
* [Configuration](#configuration)
    * [Script](#script)
    * [Gitlab](#gitlab)
* [Usage](#usage)
* [Notes](#notes)
* [Thanks](#thanks)
* [License](#license)

## Installation

* upload this script on your server
* you will need composer on your server
* run `composer.phar install --no-dev --optimize-autoloader` (composer.phar/composer)

## Configuration

### Script

* edit config.php
* required parameters in trello array:
    * token (trello api token) [if you will using this script only for you, the best option is to use token from [this page](https://trello.com/app-key) (click the link on "you can manually generate a Token.")
    * key (Trello Developer API Key) You van find it here: [https://trello.com/app-key](https://trello.com/app-key)
    * board_name or board_id (e.g. "My awesome project" or [trello-board-id]) **IMPORTANT** it's not case sensitive 
    * list_name (e.g. Issues) **IMPORTANT** it's not case sensitive
* card name format:
    * 0 (default) - no prefix, only issue name
    * 1 - [issue_num] + issue_name (e.g. `[3] fix smth`)
    * 2 - [#issue_num] + issue_name (e.g. `[#3] fix smth`)
    * 3 - #issue_num + issue_name (e.g. `#3 fix smth`)

### Gitlab

* go to your project's settings
* go to "Web hooks"
* add link to your script destination (e.g. https://example.com/gitlab-trello/index.php
* check "Issues events"
* add Web Hook

## Usage

* In your choosen Trello board->list new issues will be added every time anyone has opened an issue in your repository

## Notes

* If you want to contribute - see TODO.md for what is needed to add
* Yes, this script is very simple script, sorry for this. If you want you can improve it.

## Thanks

Great thanks to [cdaguerre](https://github.com/cdaguerre) for awesome [Trello Api Client](https://github.com/cdaguerre/php-trello-api)

## License
MIT