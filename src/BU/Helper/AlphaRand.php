<?php

namespace BU\Helper;

class AlphaRand
{
    public function get($length = 32)
    {
        $bytes = random_bytes($length);
        return bin2hex($bytes);
    }
}
