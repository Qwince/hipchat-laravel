<?php

return array(
    /*
    |--------------------------------------------------------------------------
    | HipChat Server
    |--------------------------------------------------------------------------
    |
    | For Self Hosted Servers, Leave null for default cloud account.
    |
    */
    'server' => 'insert_your_url', // this is required

    /*
    |--------------------------------------------------------------------------
    | HipChat API Token
    |--------------------------------------------------------------------------
    |
    | Required API Token from HipChat
    |
    */
    'api_token' => 'insert_your_api_token', // this is required

    /*
    |--------------------------------------------------------------------------
    | HipChat API App Name
    |--------------------------------------------------------------------------
    |
    | Choose a name you want to be displayed on HipChat
    |
    */
    'app_name' => 'Your App Name', // this is required

    /*
    |--------------------------------------------------------------------------
    | HipChat Default Room
    |--------------------------------------------------------------------------
    |
    | If Not specified, you will have to always use
    | HipChat::setRoom('roomID');
    | when a room ID is required
    |
    */
    'default_room' => 1234, // this is required

    /*
    |--------------------------------------------------------------------------
    | HipChat Default Message Format
    |--------------------------------------------------------------------------
    |
    | Determines how the message is treated by our server and rendered inside HipChat applications
    |
    | html - Message is rendered as HTML and receives no special treatment. Must be valid HTML and entities must be escaped (e.g.: '&amp;' instead of '&').
    |        May contain basic tags: a, b, i, strong, em, br, img, pre, code, lists, tables. Please see below for a list of allowed tags and attributes.
    | text - Message is treated just like a message sent by a user. Can include @mentions, emoticons, pastes, and auto-detected URLs (Twitter, YouTube, images, etc).
    |
    */
    'message_format' => 'html'
);
