<?php

/**
 * EclipticalCoordinates class.
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
 * EclipticalCoordinates class.
 *
 * PHP Version 7
 *
 * @category Coordinates
 * @author   Deepsky Developers <developers@deepskylog.be>
 * @license  GPL3 <https://opensource.org/licenses/GPL-3.0>
 * @link     http://www.deepskylog.org
 */
class EclipticalCoordinates extends Coordinates
{
    private float $_longitude;
    private float $_latitude;

    /**
     * The constructor.
     *
     * @param float $longitude The ecliptical longitude (0, 360)
     * @param float $latitude  The ecliptical latitude (-90, 90)
     */
    public function __construct(float $longitude, float $latitude)
    {
        $this->setMinValue1(0.0);
        $this->setMaxValue1(360.0);
        $this->setMinValue2(-90.0);
        $this->setMaxValue2(90.0);

        $this->setLongitude($longitude);
        $this->setLatitude($latitude);
    }

    /**
     * Sets the ecliptical longitude.
     *
     * @param float $longitude The ecliptical longitude
     *
     * @return None
     */
    public function setLongitude(float $longitude): void
    {
        if ($longitude < 0.0 || $longitude > 360.0) {
            $longitude = $this->bringInInterval1($longitude);
        }
        $this->_longitude = $longitude;
    }

    /**
     * Sets the ecliptical latitude.
     *
     * @param float $latitude The ecliptical latitude
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
     * Gets the ecliptical latitude.
     *
     * @return float the ecliptical latitude in degrees
     */
    public function getLatitude(): float
    {
        return $this->_latitude;
    }

    /**
     * Gets the ecliptical longitude.
     *
     * @return float The ecliptical longitude in degrees
     */
    public function getLongitude(): float
    {
        return $this->_longitude;
    }

    /**
     * Returns a readable string of the ecliptical longitude.
     *
     * @return string A readable string of the ecliptical longitude in degrees,
     *                minutes, seconds
     */
    public function printLongitude(): string
    {
        return $this->convertToDegrees($this->getLongitude());
    }

    /**
     * Returns a readable string of the ecliptical latitude.
     *
     * @return string A readable string of the ecliptical latitude in degrees,
     *                minutes, seconds
     */
    public function printLatitude(): string
    {
        return $this->convertToDegrees($this->getLatitude());
    }

    /**
     * Converts the ecliptical coordinates to equatorial coordinates.
     *
     * @param float $nutObliquity The nutation in obliquity
     *
     * @return EquatorialCoordinates The equatorial coordinates
     */
    public function convertToEquatorial(float $nutObliquity): EquatorialCoordinates
    {
        $ra = rad2deg(
            atan2(
                sin(deg2rad($this->_longitude)) *
                cos(deg2rad($nutObliquity)) - tan(deg2rad($this->_latitude)) *
                sin(deg2rad($nutObliquity)),
                cos(deg2rad($this->_longitude))
            )
        );

        $decl = rad2deg(
            asin(
                sin(deg2rad($this->_latitude)) * cos(deg2rad($nutObliquity))
                + cos(deg2rad($this->_latitude)) * sin(deg2rad($nutObliquity)) *
                sin(deg2rad($this->_longitude))
            )
        );

        return new EquatorialCoordinates($ra / 15.0, $decl);
    }

    /**
     * Converts the ecliptical coordinates to equatorial coordinates in
     * the J2000 equinox.
     *
     * @return EquatorialCoordinates The equatorial coordinates
     */
    public function convertToEquatorialJ2000(): EquatorialCoordinates
    {
        return $this->convertToEquatorial(23.4392911);
    }

    /**
     * Converts the ecliptical coordinates to equatorial coordinates in
     * the B1950 equinox.
     *
     * @return EquatorialCoordinates The equatorial coordinates
     */
    public function convertToEquatorialB1950(): EquatorialCoordinates
    {
        return $this->convertToEquatorial(23.4457889);
    }
}
