<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## HEROKU URL: 
Aqui encontraras la url de mi aplicación de chats en videojuegos,
https://pagesmp-heroku-chat.herokuapp.com/api


## END-POINTS USER
 
. POST /register -> para registrarse (name, email & password)<br>
. POST /login -> para logearse (email&password)<br>
. GET /profile -> veremos nuestro perfil<br>
. PUT /profile/config/id -> modificaremos nuestro profile<br>
. GET /logout -> nos deslogeamos<br>

## END-POINTS GAME

. POST /createGame -> crear un juego (name & category)<br>
. POST /adUserGame/id -> entrar en un juego<br>
. DELETE /leaveUserGame/id -> salir de un juego<br>
. GET /findParties/id -> buscar las parties que hay en un juego<br>

## END-POINTS PARTY

. POST /createParty/id -> crear una party<br>
. POST /adUserParty/id -> unirse a una party<br>
. DELETE /leaveUserParty/id -> salir de una party<br>

## END-POINTS MESSAGE

. POST /createMessage/id -> crear un mensaje<br>
. GET /viewMessages/id -> ver mensajes<br>
. DELETE /deleteMessage/id -> eliminar mensaje<br>





