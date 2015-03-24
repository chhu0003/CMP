<?php
class Container {
    private $instances = array();
    private $factories = array();

    /*
     * @Description this function will be called when something needs to be shared
     * @Example Only one Report object should exist at all times. SHARED->share("REPORTS", new Report());
     */
    public function share($name, Callable $factory)
    {
        $this->factories[$name] = $factory;
    }

    public function get($name)
    {
        if (!isset($this->instances[$name])) {
            $factory = $this->factories[$name];
            $this->instances[$name] = $factory;
        }

        return $this->instances[$name];
    }
}


