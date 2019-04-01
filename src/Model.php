<?php

namespace fvy\Korus;


class Model implements \SplSubject
{
    private $name;
    private $observers = array();
    private $content;

    public function __construct($name)
    {
        $this->name = $name;
    }

    //add observer
    public function attach(\SplObserver $observer)
    {
        $this->observers[] = $observer;
    }

    //remove observer
    public function detach(\SplObserver $observer)
    {

        $key = array_search($observer, $this->observers, true);
        if ($key) {
            unset($this->observers[$key]);
        }
    }

    //set breakouts news
    public function breakOutNews($content)
    {
        $this->content = $content;
        $this->notify();
    }

    public function getContent()
    {
        return $this->content . " ({$this->name})";
    }

    //notify observers(or some of them)
    public function notify()
    {
        foreach ($this->observers as $value) {
            var_dump($this);
            $value->update($this);
        }
    }
}