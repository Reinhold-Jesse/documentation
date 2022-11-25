<?php

namespace Reinholdjesse\Documentation\Livewire\Docs;

use Exception;
use Livewire\Component;
use Reinholdjesse\Core\Traits\addLivewireControlleFunctions;

class Edit extends Component
{

    use addLivewireControlleFunctions;

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
            $this->bannerMessage('success', 'Datei wurde erfolgreich erstellt');
            return redirect()->route('package.docs.index');
        } else {
            $this->bannerMessage('danger', 'Fehler beim erstellen der Datei.');
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
