## Upgrade Guide

Please refer to the following guides to update your Converter installation to the 1.1 version.

#### Upgrading To 1.1 From 1.0

The main and only required change is on the configuration file where we:

- Changed the base lenghts to use meters instead of kilometers
- Added some more common units like `mile`, `feet` and `inch`.
- Updated some units use abbreviations so it's more consistent with the International System of Units.

To update just you just need to run `php artisan config:publish cartalyst/converter`.

> **Note:** If you have custom units, please create a backup of the `app/config/packages/cartalyst/converter/config.php` file before executing the command above.
