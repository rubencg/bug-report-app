<?php


namespace App\Database;


use App\Exception\MissingArgumentException;

abstract class AbstractConnection
{
    protected $connection;
    protected $credentials;

    const REQUIRED_CONNECTION_KEYS = [];

    /**
     * AbstractConnection constructor.
     * @param array $credentials
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;

        if(!$this->credentialsHaveRequiredKeys($this->credentials)){
            throw new MissingArgumentException(
                sprintf('Database connection credentials are not mapped correctly, required keys: %s', implode(',', static::REQUIRED_CONNECTION_KEYS)),
                $credentials
            );
        }
    }

    /**
     * Checks if all credentials are present
     * @param array $credentials
     * @return bool
     */
    public function credentialsHaveRequiredKeys(array $credentials): bool
    {
        $matches = array_intersect_key(static::REQUIRED_CONNECTION_KEYS, $credentials);

        return count($matches) == count(static::REQUIRED_CONNECTION_KEYS);
    }

    /**
     * @param array $credentials
     * @return array
     */
    abstract protected function parseCredentials(array $credentials): array;
}