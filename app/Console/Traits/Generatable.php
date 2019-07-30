<?php

namespace Console\Traits;

trait Generatable
{
    /**
     * @var string
     */
    protected $stubDirectory = __DIR__ . '/../stubs';

    /**
     * @param $name
     * @param $replacements
     * @return mixed
     */
    public function generateStub($name, $replacements)
    {
        return str_replace(
            array_keys($replacements),
            $replacements,
            file_get_contents($this->stubDirectory . '/' . $name . '.stub')
        );
    }
}
