<?php
namespace Sketch\Helpers;

class HeadScript
{
    private $links = [];
    private $files = array();
    public function __construct()
    {
        return $this;
    }
    private function createLink($path,$media)
    {
        return array('<script src="'.\Sketch\Views\View::$instance->basePath($path).'"></script>');
    }
    public function appendFile($path,$media="screen")
    {
        if (!isset($this->files[$media])) {
            $this->files[$media] = array();
        }
        $this->files[$media] = array_merge($this->files[$media],array(str_replace("Assets/","",$path)));
        $this->links = array_merge($this->links,$this->createLink($path,$media));

        return $this;
    }
    public function prependFile($path,$media="screen")
    {
        if (!isset($this->files[$media])) {
            $this->files[$media] = array();
        }
        $this->files[$media] = array_merge(array(str_replace("Assets/","",$path)),$this->files[$media]);
        $this->links = array_merge($this->createLink($path,$media),$this->links);

        return $this;
    }

    public function __toString()
    {
        return join("",$this->links);
    }

    public function minify()
    {
        $this->links = array();
        $base = \Sketch\Views\View::$instance->basePath('minifyjs');
        $base2 = str_replace("/index.php","",\Sketch\Views\View::$instance->basePath());
        foreach ($this->files as $media => $files) {
            $this->links[] = '<script src="'.$base.'/'.
                    str_replace(
                        array(str_replace('minifyjs','',$base),$base2),"",
                    join(":",$files)).'"></script>';
        };
        return $this;
    }
}
