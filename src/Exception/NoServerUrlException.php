<?php

namespace Qwince\HipchatLaravel\Exception;

use Exception;

class NoServerUrlException extends Exception
{
    protected $message = 'HipChat Api URL could not be found';

    protected $code = 20;

    protected $file;

    protected $line;
}
