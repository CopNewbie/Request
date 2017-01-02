<?php


namespace RDuuke\Request;


class Request
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    public $query;

    public $requets;

    public $server;

    public $file;

    protected $method;

    private static $requestFactory;

    public function __construct(array $query = [], array $request = [], array $server = [], array $files = [])
    {
        $this->initialize($query, $request, $server, $files);
    }

    public function initialize(array $query = [], array $request =[], array $server =[], array $files =[])
    {
        $this->query = new ParameterBox($query);
        $this->requets = new ParameterBox($request);
        $this->server = new ParameterBox($server);
        $this->file = new FileBox($files);
        
    }
    public static function createFromGlobals()
    {
        $server = $_SERVER;
        if ('cli-server' === PHP_SAPI) {
            if (array_key_exists('HTTP_CONTENT_LENGTH', $_SERVER)) {
                $server['CONTENT_LENGTH'] = $_SERVER['HTTP_CONTENT_LENGTH'];
            }
            if (array_key_exists('HTTP_CONTENT_TYPE', $_SERVER)) {
                $server['CONTENT_TYPE'] = $_SERVER['HTTP_CONTENT_TYPE'];
            }
        }

        $request = self::createRequestFromFactory($_GET, $_POST, $_SERVER, $_FILES);

        return $request;
    }
    public function getMethod()
    {
        return $this->server->get('REQUEST_METHOD', 'GET');
    }

    public function getIp()
    {
        return $this->server-get('REMOTE_ADDR');
    }

    public function getRealIp() {
        if (!empty($this->server-get('HTTP_CLIENT_IP')))
            return $this->server-get('HTTP_CLIENT_IP');
        if (!empty($this->server-get('HTTP_X_FORWARDED_FOR')))
            return $this->server-get('HTTP_X_FORWARDED_FOR');
        return $this->server-get('REMOTE_ADDR');
    }

    private function createRequestFromFactory(
        array $query = [],
        array $request = [],
        array $server = [],
        array $files = [])
    {
        if (self::$requestFactory)
        {
            $request = call_user_func(self::$requestFactory, $query, $request, $server, $files);

            if (! $request instanceof self) {
                throw new \Exception('Error in Request Factory');
            }

            return $request;
        }

        return new static($query, $request, $server, $files);
    }

}