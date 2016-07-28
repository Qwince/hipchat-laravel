## qwince/hipchat-laravel

This a HipChat PHP Client for Laravel 5

### Installation

- Include `"qwince/hipchat-laravel"` inside the `"require"` section of `composer.json` file:

    ```php
        ...
        "require": {
            ...,
            "qwince/hipchat-laravel": "dev-master"
        }
        ...
    
    ```

- Update composer dependencies by running:

    
    ```
    composer update
    ```

- Insert `'Qwince\HipchatLaravel\HipchatLaravelServiceProvider',` in your `'providers'` array, inside `app/config/app.php`:

    ```php
    ...
    'providers' => [
        ...
        Qwince\HipchatLaravel\HipchatLaravelServiceProvider::class,
    ],
    ```
    
    
- Insert `'HipChat' => Qwince\HipchatLaravel\Facade\HipChat:class,` in your `'aliases'` array, inside `app/config/app.php`:

    ```php
    ...
    'aliases' => [
        ...
        'HipChat'         => Qwince\HipchatLaravel\Facade\HipChat::class,
    ],
    ```
    
    
- To Publish the configuration files you will need, run:

    ```
    php artisan vendor:publish --provider="Qwince\HipchatLaravel\HipchatLaravelServiceProvider"
    ```

- Edit `app/config/hipchat.php` file updating it your credentials / configurations:

    ```php
    'server' => 'insert_your_url',
    'api_token' => 'insert_your_api_token',
    'app_name' => 'Your App Name',
    'default_room' => 1234,
    
    ```
    

### Usage


- Notify in a Room

    ```php
    
    HipChat::setRoom('RoomID'); // or set default in config file 
    
    HipChat::sendMessage('My Message');
    
    // you have two optional parameters, `color` and `notify`
    // the 'red' will set the message color, and the third parameter when `true` notify all users on the room
    
    HipChat::sendMessage('My Message', 'red', true);
    
    
    
    ```
    