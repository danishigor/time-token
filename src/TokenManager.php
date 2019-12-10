<?php

namespace DanishIgor\TimeToken;

/**
 * Helper for working with temporary tokens.
 *
 * @package DanishIgor\TimeToken
 */
class TokenManager
{
    /**
     * @var integer $lifetime Token lifetime in seconds.
     */
    private $lifetime;
    /**
     * @var integer $length Length of the token along with the timestamp.
     */
    private $length;
    /**
     * @var array $characters Symbols from which the token is generated.
     */
    private $characters;

    /**
     * Constructor.
     *
     * @param integer $lifetime   Token lifetime in seconds.
     * @param integer $length     Length of the token along with the timestamp.
     * @param array   $characters Symbols from which the token is generated.
     */
    public function __construct(
        $lifetime = 3600,
        $length = 32,
        $characters = [
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r',
            's', 't', 'u', 'v', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        ]
    )
    {
        if (!is_integer($lifetime)) {
            throw new \InvalidArgumentException('The value of "$lifetime" is not an integer.');
        }

        if (!is_integer($length)) {
            throw new \InvalidArgumentException('The value of "$length" is not an integer.');
        }

        if (!is_array($characters)) {
            throw new \InvalidArgumentException('The value of "$characters" is not an array.');
        }

        if ($lifetime < 1) {
            throw new \RangeException('Life time is too short.');
        }

        // The minimum length must consist of one or more random characters, a lower slash, and a timestamp.
        if ($length < 2 + strlen(time())) {
            throw new \RangeException('The specified length is too short.');
        }

        if (count($characters) < 1) {
            throw new \RangeException('The array of characters to generate is empty.');
        }

        $this->lifetime = $lifetime;
        $this->length = $length;
        $this->characters = $characters;
    }

    /**
     * Generate.
     *
     * @return string
     */
    public function generate()
    {
        $time = time();

        return $this->generateRandomString($this->length - strlen($time) - 1) . '_' . $time;
    }

    /**
     * Check.
     *
     * @param null|string $token Token.
     *
     * @return bool
     */
    public function check($token = null)
    {
        if (empty($token)) {
            return false;
        }

        $bottomSlashPosition = strrpos($token, '_');

        if ($bottomSlashPosition === false) {
            return false;
        }

        return intval(substr($token, $bottomSlashPosition + 1)) + $this->lifetime >= time();
    }

    /**
     * Generate string.
     *
     * @param integer $length Generated string length.
     *
     * @return string
     **/
    private function generateRandomString($length)
    {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, count($this->characters) - 1);
            $result = $result . $this->characters[$index];
        }

        return $result;
    }
}
