<?php

/**
 * GeographicalCoordinates class.
 *
 * PHP Version 7
 *
 * @category Coordinates
 * @author   Deepsky Developers <developers@deepskylog.be>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 * @link     http://www.deepskylog.org
 */

namespace deepskylog\AstronomyLibrary\Coordinates;

/**
 * GeographicalCoordinates class.
 *
 * PHP Version 7
 *
 * @category Coordinates
 * @author   Deepsky Developers <developers@deepskylog.be>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 * @link     http://www.deepskylog.org
 */
class GeographicalCoordinates extends Coordinates
{
    private float $_longitude;
    private float $_latitude;

    /**
     * The constructor.
     *
     * @param float $longitude The geographical longitude (-180 ,180)
     * @param float $latitude  The geographical latitude (-90, 90)
     */
    public function __construct(float $longitude, float $latitude)
    {
        $this->setMinValue1(-180.0);
        $this->setMaxValue1(180.0);
        $this->setMinValue2(-90.0);
        $this->setMaxValue2(90.0);

        $this->setLongitude($longitude);
        $this->setLatitude($latitude);
    }

    /**
     * Sets the geographical longitude.
     *
     * @param float $longitude The geographical longitude
     *
     * @return None
     */
    public function setLongitude(float $longitude): void
    {
        if ($longitude < -180.0 || $longitude > 180.0) {
            $longitude = $this->bringInInterval1($longitude);
        }
        $this->_longitude = $longitude;
    }

    /**
     * Sets the geographical latitude.
     *
     * @param float $latitude The geographical latitude
     *
     * @return None
     */
    public function setLatitude(float $latitude): void
    {
        if ($latitude < -90.0 || $latitude > 90.0) {
            $latitude = $this->bringInInterval2($latitude);
        }
        $this->_latitude = $latitude;
    }

    /**
     * Gets the geographical longitude.
     *
     * @return float The geographical longitude
     */
    public function getLongitude(): float
    {
        return $this->_longitude;
    }

    /**
     * Gets the geographical latitude.
     *
     * @return float The geographical latitude
     */
    public function getLatitude(): float
    {
        return $this->_latitude;
    }

    /**
     * Returns a readable string of the latitude.
     *
     * @return string A readable string of the coordinate in degrees,
     *                minutes, seconds
     */
    public function printLatitude(): string
    {
        return $this->convertToDegrees($this->getLatitude());
    }

    /**
     * Returns a readable string of the longitude.
     *
     * @return string A readable string of the coordinate in degrees,
     *                minutes, seconds
     */
    public function printLongitude(): string
    {
        return $this->convertToDegrees($this->getLongitude());
    }
}
