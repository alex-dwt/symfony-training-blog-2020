<?php

declare(strict_types=1);

namespace App\Application\Bus\Message;

class CreateUserCommand
{
    private string $name;
    private string $country;
    private string $city;

    public function __construct(
        string $name,
        string $country,
        string $city
    ) {
        $this->name = $name;
        $this->country = $country;
        $this->city = $city;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function city(): string
    {
        return $this->city;
    }
}
