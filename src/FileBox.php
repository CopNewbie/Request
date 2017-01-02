<?php


namespace RDuuke\Request;


class FileBox extends ParameterBox
{
    protected $parameters = [];

    public function __construct(array $parameters= [])
    {
        $this->parameters = $parameters;
    }
    
    public function get($name)
    {
        return isset($this->parameters[$name])
            ? new FileBox($this->parameters[$name])
            : null;
    }

    public function __call($name, $arg = [])
    {
        return isset($this->parameters[$name])
            ? $this->parameters[$name]
            : null;
    }

    public function moveTo($path)
    {
        return move_uploaded_file(
            $this->parameters['tmp_name'],
            "$path/".$this->parameters['name']
        );
    }

    protected function extension()
    {
        return end(explode('.', $this->parameters['name']));
    }

    public function isImage()
    {
        if (! $this->type() == Formats::IMAGE ) {
            return false;
        }
        return true;
    }

    public function isAudio()
    {
        if (! $this->type() == Formats::AUDIO ) {
            return false;
        }
        return true;
    }
    public function isVideo()
    {
        if (! $this->type() == Formats::Video ) {
            return false;
        }
        return true;
    }

    protected function type()
    {
        return explode('/',$this->parameters['type'])[0];
    }
}