<?php

namespace fvy\Korus;

class Template
{
    private $_scriptPath = TEMPLATE_PATH;
    public $properties;

    public function __construct()
    {
        $this->properties = array();
    }

    public function render($filename, $data = null)
    {
        ob_start();
        $tmpl = $this->_scriptPath . "/" . $filename . ".php";
        if (file_exists($tmpl)) {
            include($tmpl);
        } else {
            throw new \Exception("Can't find template ``" . $tmpl . "``");
        }
        return ob_get_clean();
    }

    public function __set($k, $v)
    {
        $this->properties[$k] = $v;
    }

    public function __get($k)
    {
        return $this->properties[$k];
    }
}