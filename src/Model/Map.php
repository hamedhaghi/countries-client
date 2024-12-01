<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class Map {
    
    /** @var string */
    private $googleMaps;

    /** @var string */
    private $openStreetMaps;

    /**
     * @param string $googleMaps    
     * @param string $openStreetMaps
     */
    public function __construct(string $googleMaps, string $openStreetMaps) {
        $this->googleMaps = $googleMaps;
        $this->openStreetMaps = $openStreetMaps;
    }

    /**
     * @return string
     */
    public function getGoogleMaps(): string {
        return $this->googleMaps;
    }

    /**
     * @return string
     */
    public function getOpenStreetMaps(): string {
        return $this->openStreetMaps;
    }
}