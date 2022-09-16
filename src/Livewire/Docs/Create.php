<?php

namespace Reinholdjesse\Documentation\Livewire\Docs;

use Exception;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public $root = './../docs/';

    public $content;

    public $folder_list = [];

    public $child_folder;

    protected $listeners = [
        'markdown-x:update' => 'updateBody',
    ];

    public function mount()
    {
        $this->scandirFolder($this->root);
    }

    public function render()
    {
        //dd($this->folder_list);
        return view('documentation::livewire.docs.create')->layout('component::layouts.dashboard');
    }

    public function updateBody($value)
    {
        $this->content = $value;
    }

    public function save()
    {
        if (!empty($this->content)) {

            //dd($this->content);
            try {
                $headline = $this->getHeadlineFromContent($this->content);
            } catch (Exception $e) {
                dd($e);
            }
        }

        if (isset($headline) && !empty($headline) && $this->createMarkdownFile(Str::slug(trim($headline)))) {
            // datei erstellt
            // TODO: flash message
            //dd('datei erstellt');
            return redirect()->route('package.docs.index');
        } else {
            // datei kann nicht erstellt werden.
            // TODO: flash message
        }

    }

    private function scandirFolder(string $directory)
    {
        foreach (scandir($directory) as $element) {
            if ($element != '..' && $element != '.') {

                if (is_dir($directory . '/' . $element)) {
                    $this->isFolder($directory, $element);
                }
            }
        }
    }

    private function isFolder(string $directory, string $element)
    {
        $element = trim($element);
        $folder['type'] = 'folder';
        $folder['title'] = $element;
        $folder['path'] = $directory . '/' . $element;

        $this->folder_list[] = $folder;

        $this->scandirFolder($directory . '/' . $element);
    }

    private function getHeadlineFromContent($content)
    {
        $re = '/(^#{1}\s[a-zA-ZüÜäÄöÖß].*$\n{1})/m';

        if (preg_match($re, $content, $matches, PREG_OFFSET_CAPTURE, 0)) {
            //dd($matches);

            if (isset($matches[0]) && !empty($matches[0])) {

                return preg_replace(['/#/', '/\n/'], ['', ''], $matches[0][0]);
            }
        }

        return null;
    }

    private function createMarkdownFile(string $filename)
    {
        if (isset($this->child_folder) && !empty($this->child_folder)) {
            $path = $this->child_folder . '/' . $filename;
        } else {
            $path = $this->root . $filename;
        }

        if ($fp = fopen($path . '.md', 'w')) {
            try {
                fwrite($fp, $this->content);
                //return file_put_contents($this->root . $filename . '.md', $this->content, FILE_APPEND | LOCK_EX);
            } catch (Exception $e) {
                dd($e);
            }

            fclose($fp);
            return true;
        }

        return null;
    }

}
