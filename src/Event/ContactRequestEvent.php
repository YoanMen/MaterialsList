<?php

namespace App\Event;

class ContactRequestEvent
{
    public function __construct(public string $product)
    {
    }
}
