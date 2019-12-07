<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Assessment

1. Create a form to create an admin account with the following fields:

    - Name
    - E-mail address
    - Password + confirmation
    - Add Catpcha validation (Google ReCaptcha or similar)

2. Log in to your account with a view that says `Hi *name*, welcome to your admin account`.
3. Add a list of clients view. Create a simple CRUD for the client model with fields: name,
email, profile picture.
4. A simple scheduled task to send the client list via email weekly is setup on the Console
Commands.

## Requirements

- An admin can only see his own clients (authorization).
- Follow all the good practice concepts you normally follow.
- Include all the details you think convenient for an application of this type.
- Avoid Laravel scaffolding, write your own Controller methods and simple authentication Middleware.
- Profile picture files can be saved on the public folder.
- Command email doesn’t have to send, can use log driver.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
