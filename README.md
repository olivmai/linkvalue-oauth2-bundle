# Google Provider for OAuth 2.0 Client

This package provides Linvalue OAuth 2.0 support for an authentication through [LV Connect](https://github.com/Linkvalue-Interne/LvConnect).

## Installation

To install, use composer:

```sh
composer require olivmai/linkvalue-oauth2-bundle
```

## Usage

### Configuration file

```yaml
# config/packeges/linkvalue_oauth2.yaml
linkvalue_oauth2:
    client_id: # app_id from LV Connect
    client_secret: # app_secret from LV Connect
    redirect_uri: # url specified in LV Connect
    scopes: # must one or more defined in LV Connect
```


## Credits

- [Olivier Mairet](https://github.com/olivmai)


## License

The MIT License (MIT).
