[![Build Status](https://travis-ci.org/hanhan1978/RestApiExtention.svg)](https://travis-ci.org/hanhan1978/RestApiExtention)

RestApiExtension
=========
is an extension for REST API testting with Behat
  

# Installation 

## via composer

```
    "require": {
        "hanhan1978/restapi-extention": "1.0.0"
    },
```

# Settings for behat.yml

```
default:
    extensions:
        Behat\RestApiExtension: 
            base_url: http://127.0.0.1:3000/
    suites:
        default:
            contexts:
              - 'Behat\RestApiExtension\Context\RestApiContext'
```
=> change base_url to your own.
