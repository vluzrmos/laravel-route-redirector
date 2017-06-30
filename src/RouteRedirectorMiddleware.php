<?php

namespace Vluzrmos\RouteRedirector;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class RouteRedirectorMiddleware
{
    /**
     * @var Redirector
     */
    protected $redirector;

    /**
     * @var Request
     */
    protected $request;

    /**
     * RouteRedirector constructor.
     * @param Request $request
     * @param Redirector $redirector
     */
    public function __construct(Request $request, Redirector $redirector)
    {
        $this->redirector = $redirector;
        $this->request = $request;
    }

    /**
     * @param $response
     * @param \Closure $next
     * @param null $method
     * @return mixed
     * @throws Exception
     */
    public function handle($response, \Closure $next, $method = null)
    {
        $action = $this->request->route()->getAction();
        $methods = ['to', 'route', 'away', 'action'];

        if ($method) {
            if ($method && in_array($method, $methods) && func_num_args() > 3) {
                $params = array_slice(func_get_args(), 3);

                $this->parseParams($params);

                return $this->redirect($method, $params);
            }

            throw new Exception('Redirect method not found or some parameters are missing.');
        }

        foreach ($methods as $method) {
            if (isset($action[$key = 'redirect_'.$method])) {
                $params = $action[$key];

                $params = is_array($params) ? $params : [$params];

                return $this->redirect($method, $params);
            }
        }

        throw new Exception('Redirect method not found.');
    }

    /**
     * @param $method
     * @param array $params
     * @return mixed
     */
    protected function redirect($method, array $params = [])
    {
        return call_user_func_array([$this->redirector, $method], $params);
    }

    /**
     * @param $params
     * @return array
     */
    protected function parseParams(&$params)
    {
        foreach ($params as $k => &$v) {
            if (in_array($v, ['', 'null', 'NULL'], true)) {
                $v = null;
            }
        }

        return $params;
    }
}