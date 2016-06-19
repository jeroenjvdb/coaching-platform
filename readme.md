# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

---
# Topswim
## omschrijving
Topswim is een web applicatie bedoeld voor trainers van competitieve zwemgroepen.

Een zwemmer van redelijk niveau moet om zijn niveau te onderhouden minstens 5 a 6 keer per week trainen. Hierdoor zijn er vaak meerdere trainers nodig om bij deze verschillende trainingen aanwezig te zijn.

Dit brengt met zich mee dat coaches vaak geen idee hebben wat er op andere trainingen gaande is. Bepaalde aandachtspunten voor de zwemstijl worden aangebracht op een training, maar als andere coaches hier geen weet van hebben bestaat de kans dat het een week duurt voor diezelfde coach opnieuw naar dat aandachtspunt kijkt.

Het is zeer belangrijk dat de juiste soort training op het juiste moment valt. Na enkele zware trainingen heeft een zwemmer recuperatie nodig. Maar er zijn natuurlijk ook genoeg zware trainingen nodig. Je kan niet zomaar ter plekke een training verzinnen, dit moet allemaal grondig ingepland worden.

Topswim zal deze grote problemen binnen de zwemwereld verhelpen. Dit uniek coaching platform zorgt ervoor dat communicatie tussen trainers alsook communicatie tussen trainer en zwemmer veel vlotter verloopt. Door het verzamelen van de data rondom de zwemmer en de mogelijkheid om buiten de training nog makkelijk te communiceren kunnen de verschillende coaches samen beter helpen om de zwemmers tot een hoger niveau te brengen.

De kern van de applicatie is een groep. iedere groep bevat zwemmers, coaches en trainingen.
Per zwemmer wordt een profiel aangemaakt. Hierin wordt de persoonlijke data vastgelegd zoals techniekwerkpunten, gewicht, hartritme in rust, trainingstijden en wedstrijdtijden. Bij de techniekwerkpunten kunnen foto's en video’s toegevoegd worden om zo te verduidelijken waar het over gaat. Beelden zeggen meer dan woorden en deze beelden dienen ook om de evolutie te bepalen.

Trainingstijden worden via de applicatie zelf opgenomen aan de hand van een ingebouwde stopwatch. Deze tijden en tussentijden worden automatisch in de Topswim Database opgeslagen, zodat ze niet meer opgeschreven moeten worden tijdens de training en ze nadien ook makkelijk raadpleegbaar zijn voor alle trainers.

Besttijden van een zwemmer, gezwommen tijdens officiële wedstrijden, moeten na een wedstrijd niet meer door een trainer opgezocht en bijgehouden worden. Deze worden dagelijks van de website Swimrankings opgehaald en lokaal bijgewerkt. Op deze manier lopen de wachttijden tijdens het raadplegen niet op en kunnen de tijden geraadpleegd worden ook al is de site van de 3de partij niet beschikbaar.

De zwemmers kunnen op hun eigen profiel, naast het bekijken van data, ook  op een eenvoudige manier communiceren met zijn trainers. Problemen die een invloed hebben op hun prestaties, zoals een blessure, ziekte, moeilijkheden op school en dergelijke worden hier gemeld zodat alle coaches op de hoogte zijn van de status van de zwemmer.

De trainingen die aan de groep worden toegevoegd zijn ten allen tijde voor alle coaches beschikbaar. Ze bestaan uit categorieën waarbij de categorieën oefeningen bevatten. Op deze manier is het zeer overzichtelijk om te volgen waar je bent in de training. Bij de uitwerking van de training worden de afstand van bepaalde sets gegeven. Naast de coaches is er ook de mogelijkheid de trainingen beschikbaar te maken voor de zwemmers, om af te drukken wanneer zelfstandig gaan trainen, of zich willen voorbereiden op wat nog komen zal.

Naast zwemtrainingen hebben veel zwemmers ook nog een uitgebreid fitnessprogramma. Aangezien het grootste deel van de avonden al voorzien is voor de zwemtraining, moeten de zwemmers de fitnesstraining op een eigen gekozen moment uitvoeren. Via dit platform deelt de trainer mee hoeveel fitnesstrainingen er afgewerkt moeten worden en welke oefeningen er gedaan moeten worden.

Het belangrijkste aspect van de Topswim applicatie is dat deze mobiel toegankelijk is. Coaches hebben veeleer een smartphone bij aan de rand van het zwembad dan een laptop, en daarenboven is er niet in alle zwembaden wifi beschikbaar. Daarom heb ik ervoor gekozen om de applicatie zo mobiel mogelijk te maken. Maar de applicatie is, zoals voor het schrijven van de trainingen en voor de verschillende communicaties, op de computer even vlot in gebruik.

## technologieën
Mijn project steunt op een PHP backend in het Laravel framework. Deze staat in contact met een MySQL database. Vanuit de backend wordt er met HTML, CSS en JavaScript da pagina’s opgebouwd. De CSS is gecompiled aan de hand van Sass. Wanneer de front end nieuwe data nodig heeft zonder een page refresh te doen zal de JavaScript via AJAX een request sturen naar de back end.
## installatie
clone de git repository.

```git  clone https://github.com/jeroenjvdb/coaching-platform.git```

Stel de public directory in als root directory.

installeer met composer 
`composer install`

maak in mysql een database aan

`CREATE DATABASE [db-name]`

stel in de .env file volgende variabelen in:
``` .env
APP_DEBUG=false
APP_ENV=staging
APP_KEY=test
APP_URL=...
APP_NAME=Topswim

DB_HOST=127.0.0.1
DB_USERNAME=...
DB_PASSWORD=...
DB_DATABASE=[db-name]

BROADCAST_DRIVER=redis

MAIL_DRIVER=mailgun
MAIL_HOST=smtp.mailgun.org
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...

MAILGUN_DOMAIN=...
MAILGUN_SECRET=...
```
en zet meteen de random app key na opslaan door het uitvoeren van het commando

`php artisan key:generate`

voor de database te vullen met tabellen voer volgend commando uit:

`php artisan migrate --seed`

de testuser is dan `jeroen_vdb1@hotmail.com` en het wachtwoord is `root`

