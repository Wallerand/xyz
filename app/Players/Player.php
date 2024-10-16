<?php

namespace App\Players;

use RuntimeException;

class Player
{
    /** @var array<string,string> Supported players */
    protected $players = [
        'youtube' => Providers\YoutubePlayer::class,
        'soundcloud' => Providers\SoundcloudPlayer::class
    ];

    /**
     * Instantiate a player from its name.
     */
    public function fromName(mixed $name): PlayerInterface|null
    {
        if (! isset($this->players[$name])) {
            return null;
        }

        return app($this->players[$name]);
    }

    /**
     * Determine provider from given URL.
     */
    public function guessFromUrl(string $url): PlayerInterface
    {
        foreach ($this->players as $player) {
            if (app($player)->match($url)) {
                return app($player);
            }
        }

        throw new RuntimeException("Unknown or unsupported player.");
    }

    /**
     * Validate given URL.
     */
    public function validate(string $url): bool
    {
        foreach ($this->players as $player) {
            if (app($player)->validate($url)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get track details for given URL.
     */
    public function details(string $url): TrackDetails
    {
        return $this->guessFromUrl($url)->resolve($url);
    }

    /**
     * Get track embed code for given $player and $trackId, or null.
     */
    public function embed(string $player, string $trackId): string|null
    {
        if ($player = app(Player::class)->fromName($player)) {
            return $player->embed($trackId);
        }

        return null;
    }
}
