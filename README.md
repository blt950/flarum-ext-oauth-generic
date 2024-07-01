# Log in with custom OAuth2 Server

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/blt950/oauth-generic.svg)](https://packagist.org/packages/blt950/oauth-generic) [![Total Downloads](https://img.shields.io/packagist/dt/blt950/oauth-generic.svg)](https://packagist.org/packages/blt950/oauth-generic)

A [Flarum](http://flarum.org) extension. Reddit oauth provider for Flarum

![](https://extiverse.com/extension/blt950/oauth-generic/open-graph-image)

## Features

Adds a `Generic` provider to [FoF OAuth](https://github.com/FriendsOfFlarum/oauth) to enable `Login with <your custom provider>` functionality.

## Installation

Install with composer:

```sh
composer require blt950/oauth-generic
```

## Configuration
### Admin Panel

Example configuration, please consult your provider for the correct values.
- Client ID `<id from your provider>`
- Client Secret `<secret from your provider>`
- Scope `<scope from your provider>` or empty
- Authorization Endpoint `https://yourprovider.com/oauth/authorize`
- Token Endpoint `https://yourprovider.com/oauth/token`
- User Information Endpoint `https://yourprovider.com/api/user`

To correctly find your user fields that might be nested in arrays, the parameters support nesting such as:
- User ID `data-id`
- Username `data-username`
- Email `data-personal-email`

Forcing or suggesting fields gives you the possiblity to force or pre-fill a suggested value when signing up the user.

- Force User ID `1` or `0`.
- Force Display Name `1` or `0`.
- Force Email `1` or `0`.

### Provider Name
If you wish to change the name of provider you can do so by editing the locale file. I did not find a way to make this dynamic.

## Updating

```sh
composer update blt950/oauth-generic
php flarum cache:clear
```

## Requests and Issues
Please file a pull request if you find issues or want to expand the functionality. Thank you for contributing.

### Known quirks and bugs
- The nickname input field in signup modal fills in username regardless of display name is provided. This is due to get fixed [in this pull request for a future Flarum version](https://github.com/flarum/framework/pull/4004)
- The icon of provider in admin panel is invisible due to FoF OAuth plugin forces a font-weight that won't display the font, it shows correctly other places though.
- The force settings are a boolean but have a string input, simply because boolean values are not supported for provider settings.

## Links

- [Packagist](https://packagist.org/packages/blt950/oauth-generic)
- [GitHub](https://github.com/blt950/flarum-ext-oauth-generic)
- [Discuss](https://discuss.flarum.org/d/34777-generic-and-customized-oauth2)