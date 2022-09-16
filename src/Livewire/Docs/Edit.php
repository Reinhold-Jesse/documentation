<?php

namespace Reinholdjesse\Documentation\Livewire\Docs;

use Exception;
use Livewire\Component;

class Edit extends Component
{

    public $root = './../docs/';

    public $file;
    public $content;

    protected $listeners = [
        'markdown-x:update' => 'updateBody',
    ];

    public function mount(string $path)
    {
        $this->file = $path;
        $this->content = $this->loadContentFromPath($this->file);
    }

    public function render()
    {
        return view('documentation::livewire.docs.edit')->layout('component::layouts.dashboard');
    }

    public function updateBody($value)
    {
        $this->content = $value;
    }

    public function save()
    {

        if ($this->createMarkdownFile()) {
            // TODO: flash message
            // datei gespeichert
            return redirect()->route('package.docs.index');
        } else {
            // TODO: flash message
        }
    }

    private function loadContentFromPath(string $path)
    {
        try {
            return file_get_contents($this->root . '/' . $path);
        } catch (Exception $e) {
            dd($e);
        }

    }

    private function createMarkdownFile()
    {
        $path = $this->root . $this->file;

        if ($fp = fopen($path, 'w')) {
            try {
                fwrite($fp, $this->content);
            } catch (Exception $e) {
                dd($e);
            }

            fclose($fp);
            return true;
        }

        return null;
    }
}
