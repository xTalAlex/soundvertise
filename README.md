[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2Fbc543134-ccb4-41d8-a126-65b3f47fe459&style=plastic)](https://forge.laravel.com/servers/824510/sites/2410284)

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

## Registration

    - blocco playlist con < 1000 follower
    - validazione inline
    - avatar overflow

## Playlist

    - controllare errori 404 e 500
    - rimozione playlist > quando non è coinvolta in match attivi
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
