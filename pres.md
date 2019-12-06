%title: Creating simple App for getting best Currencies Exchange Rates
%author: SmoothCode
%date: 2019-12-06

-> # Intro <-

Hello,
I'm going to show you the process of creating simple application in PHP with Laravel which will
be responsible for getting info about actual currency rates and notify about BEST rate.

This will be just first part of the series in which I will create core, domain models and
implementation of CQRS/ES.

Parts of series:

* Creating boiler plate with domain models and CQRS/ES implementation (this part)
* Consuming API with actual Currencies Rates
* Creating frontend part of application using Angular 2+ (probably v8) and running it as PWA (Progressive Web App)
* Implementing Web Socket to notify client app about best currency rate


-----------------------------------------------------------------

-> # Slide 2 <-
================

I have already created a part of code.

* Created laravel skeleton project with composer
* Installed Event Sauce library with composer (composer require eventsauce/eventsauce)
* Created src catalog in project root and added it to composer autoload:

```json
         "autoload": {
            "psr-4": {
                "App\\": "app/",
                "CurrencX\\": "src/"
            },
         },
```

* Created Domain model for ExchangeRate and ExchangeRateRepository

## WARNING: If you're not familiar with CQRS/ES it would be better for you to read a litte about it before

----------------------------------------------------------

-> # Slide 3 <-

Now I'm going to implement MessageRepository which will be responsible for handling saving events in EventStore
