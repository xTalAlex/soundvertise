<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

### Premium Partners

-   **[OP.GG](https://op.gg)**

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Packages

-   [AFrame](https://aframe.io/docs/1.5.0/introduction/)
-   [Vanilla Tilt](https://micku7zu.github.io/vanilla-tilt.js/index.html)

https://devbeep.com/mouse-trail-effects/

080808
116dff
8b4cb7
https://www.csshero.org/
https://coolors.co/116dff-8b4cb7-080808-e4b7e5-fffeff
https://colorhunt.co/palettes/neon

https://developer.spotify.com/documentation/web-api

https://pushinjs.com/api#layers

https://superhi-videos.s3.amazonaws.com/tutorials/midnight-mouse-trail/index.html

https://d3js.org/

## Spotify Web API

### Get User's Playlist

-   total
-   items
    -   collaborative
    -   public
    -   name
    -   description
    -   external_urls.spotify
    -   id
    -   tracks.total

### Get Playlist

-   followers.total
-   tracks
    -   limit, offset
    -   total
    -   items.popularity

### Add items to playlist

### Remove playlist items

### Search for item

https://github.com/DO-Solutions/DigitalOcean-AppPlatform-Cron

https://www.memcachier.com/documentation/laravel

https://www.digitalocean.com/community/questions/how-to-setup-laravel-queue-for-app

# TODO

## General

    - responsive design
    - rendere navbar più simmetrica

## Registration

    - caricamento screenshot obbligatorio
        - sostituzione file caricati
        - ?visualizzazione file caricati
    - blocco playlist con < 1000 follower
    - screenshot d'esempio
    - iscrizione senza playlist
    - separare login da register
    - validazione inline

    - avatar overflow
    - register button scompare durante redirect

## Playlist

    - stato di approvazione playlist
    - livello playlist
    - gestire caso in cui playlist approvata venga resa privata o eliminata
    - aggiornare periodicamente tot followers e tracks (ad ogni submission) [fatto]

## Profile

    - layout

## Galaxy

    - countdown
    - sfondo bottone choose song
    - transizione a pianeta singolo
    - layout pianeta singolo
    - generazione orbite galaxy main page
    - creazione submission
    - aggiungere filtri in base a livello playlist
    - ctr pairings ctr matches

## Pagina Pairings

    - filtri
        - richieste ricevute (ciclo corrente)
            - in base al livello
            - stima posizione in base a match accettati dall'altro utente

        - match correnti
        - scheduling attivi
        - match passati raggruppati per canzone

## Scheduler

    - rimozione canzone dalla playlist
    - pulizia pairing senza match
    - riesaminare mensilmente playlist approvate

## Notifiche

    - toggle notifiche da profilo

# Admin

    - widget
        - submission attive
    - filtri
    - processi di cancellazione
    - soft deletes (user,canzoni,playlist)
    - aggiornamento manuale dati spotify utente, playlist, canzone

# Subscriptions

    - billing info sync con stripe
    - invoice automatiche e raccolta taxId
