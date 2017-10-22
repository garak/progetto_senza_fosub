<?php

namespace Tests;

/**
 * Eccezione serializzabile da usare nel test di AuthController.
 */
class SerializableException extends \Exception implements \Serializable
{
    public function serialize()
    {
        return 'serialized...';
    }

    public function unserialize($serialized)
    {
        return ['unserialized...'];
    }
}
