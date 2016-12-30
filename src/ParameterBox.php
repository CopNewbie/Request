<?php


namespace RDuuke\Request;


class ParameterBox implements \Countable
{

    protected $parameters = [];

    public function __construct(array $parametes = [])
    {
        $this->parameters = $parametes;
    }

    public function all()
    {
        return $this->parameters;
    }

    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->parameters)
            ? $this->parameters[$key]
            : $default;
    }

    public function set($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    public function remove($key)
    {
        unset($this->parameters[$key]);
    }

    public function has($key)
    {
        return array_key_exists($key, $this->parameters);
    }
    public function count()
    {
        return count($this->parameters);
    }
}