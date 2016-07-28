<?php

namespace Qwince\HipchatLaravel;

use Qwince\HipchatLaravel\Exception\NoServerUrlException;
use Qwince\HipchatLaravel\Exception\NoApiTokenException;
use Qwince\HipchatLaravel\Exception\NoAppNameException;
use Qwince\HipchatLaravel\Exception\RoomNotDefinedException;
use Qwince\HipchatLaravel\Exception\UserNotDefinedException;

class HipChat
{
    /**
     * Colors for rooms/message
     */
    const COLOR_YELLOW = 'yellow';
    const COLOR_RED = 'red';
    const COLOR_GRAY = 'gray';
    const COLOR_GREEN = 'green';
    const COLOR_PURPLE = 'purple';
    const COLOR_RANDOM = 'random';


    /**
     * @var HipChatClient
     */
    protected $hipchat;

    /**
     * @var string
     */
    protected $server = null;

    /**
     * @var string
     */
    protected $api_token;

    /**
     * @var string
     */
    protected $app_name;

    /**
     * @var string|null
     */
    protected $room = null;

    /**
     * @var string|null
     */
    protected $user = null;


    /**
     * @var string|null
     */
    protected $message_format = null;


    /**
     * HipChat constructor.
     */
    public function __construct()
    {
        $this->api_token = config('hipchat.api_token', null);
        $this->app_name = config('hipchat.app_name', null);
        $this->room = config('hipchat.default_room', null);
        $this->server = config('hipchat.server', null);
        $this->message_format = config('hipchat.message_format', null);

        if ($this->server)
            $this->hipchat = new HipChatClient($this->api_token, $this->server);
        else
            throw new NoServerUrlException();
    }

    protected function verify()
    {
        if (!$this->api_token) {
            throw new NoApiTokenException();
        }

        if (!$this->app_name) {
            throw new NoAppNameException();
        }
    }

    protected function checkRoom()
    {
        $this->verify();
        if (!$this->room) {
            throw new RoomNotDefinedException();
        }
    }

    protected function checkUser()
    {
        $this->verify();
        if (!$this->user) {
            throw new UserNotDefinedException();
        }
    }

    public function setRoom($room_id)
    {
        $this->room = $room_id;
        $this->verify();
    }

    public function returnRoom()
    {
        return $this->room;
    }

    public function sendMessage($message, $color = self::COLOR_GREEN, $notify = false)
    {
        $this->checkRoom();
        $this->hipchat->message_room($this->room, $this->app_name, $message, $notify, $color, $this-$this->message_format);
    }

    public function sendInfo($message, $color = self::COLOR_GREEN, $notify = false)
    {
        $this->checkRoom();
        $this->hipchat->message_room($this->room, $this->app_name, $message, $notify, $color, $this->message_format);
    }

    public function sendWarn($message, $color = self::COLOR_YELLOW, $notify = false)
    {
        $this->checkRoom();
        $this->hipchat->message_room($this->room, $this->app_name, $message, $notify, $color, $this->message_format);
    }

    public function sendAlert($message, $color = self::COLOR_RED, $notify = false)
    {
        $this->checkRoom();
        $this->hipchat->message_room($this->room, $this->app_name, $message, $notify, $color, $this->message_format);
    }

}
