<?php

namespace Reinholdjesse\Documentation\Livewire\Docs;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component
{
    public $root = 'docs';

    public $navigation;

    public $select_file;

    public $content;

    public $folder_list = [];

    public $new_folder;

    public $child_folder;

    public function mount()
    {
        if (!file_exists(base_path($this->root))) {
            mkdir(base_path($this->root));
        }

        //dd(scandir(app_path('./../' . $this->root)));

        //dump($this->navigation);

    }

    public function render()
    {
        $this->navigation = $this->scandirFolder('./../' . $this->root);

        //dump($this->folder_list);

        return view('documentation::livewire.docs.index')->layout('component::layouts.dashboard');
    }

    public function select(string $directory)
    {
        //dd($directory);

        $this->select_file = $file['edit'] = str_replace('./../docs/', '', $directory);

        try {
            $this->content = File::get($directory);
        } catch (Exception $e) {
            dd($e);
        }

    }

    public function deleteFile(string $directory)
    {
        try {
            unlink($directory);
        } catch (Exception $e) {
            dd($e);
            // TODO: flash message
            // File konte nicht gelöscht werden.
        }
        // TODO: flash message
        // File wurde gelöscht
    }

    public function deleteFolder(string $directory)
    {
        try {
            rmdir($directory);
        } catch (Exception $e) {
            dd($e);

            // TODO: flash message
            // Ordner ist nicht leer
        }
        // TODO: Ordner wurde gelöscht
    }

    public function createNewFolder()
    {
        if (isset($this->new_folder) && !empty($this->new_folder)) {

            $folder = Str::slug(trim($this->new_folder));

            if (isset($this->child_folder) && !empty($this->child_folder)) {
                $path = $this->child_folder . '/' . $folder;
            } else {
                $path = './../' . $this->root . '/' . $folder;
            }

            if (!file_exists($path)) {

                try {
                    mkdir($path);
                } catch (Exception $e) {
                    dd($e);
                }

                $this->new_folder = null;
                $this->child_folder = null;

                $this->emit('render');

                // TODO:flash message folder created
            } else {
                dd('wurde gefunden');
                // TODO: flash message
            }
        }
    }

    private function scandirFolder(string $directory)
    {
        $temp = [];

        foreach (scandir($directory) as $element) {
            if ($element != '..' && $element != '.') {

                if (is_dir($directory . '/' . $element)) {
                    $temp[] = $this->isFolder($directory, $element);
                }
                if (is_file($directory . '/' . $element)) {
                    $temp[] = $this->isFile($directory, $element);
                }
            }
        }
        return $temp;
    }

    private function isFile(string $directory, string $element)
    {
        try {
            $content = $this->getContent($directory . '/' . $element);
        } catch (Exception $e) {
            dd($e);
        }

        if (isset($content) && !empty($content)) {
            try {
                $headline = $this->getHeadlineFromContent($content);
            } catch (Exception $e) {
                dd($e);
            }
        }

        $file['type'] = 'file';

        if (isset($headline) && !empty($headline)) {
            $file['title'] = trim($headline);
        } else {
            $element = trim($element);
            $file['title'] = $element;
        }

        $file['path'] = $directory . '/' . $element;
        return $file;
    }

    private function isFolder(string $directory, string $element)
    {
        $element = trim($element);
        $folder['type'] = 'folder';
        $folder['title'] = $element;
        $folder['path'] = $directory . '/' . $element;

        $this->folder_list[] = $folder;

        $folder['data'] = $this->scandirFolder($directory . '/' . $element);

        return $folder;
    }

    private function getContent(string $file)
    {
        return file_get_contents($file);
    }

    private function getHeadlineFromContent($content)
    {
        $re = '/(^#\s[a-zA-ZüÜäÄöÖß].*$\n)/m';

        preg_match($re, $content, $matches, PREG_OFFSET_CAPTURE, 0);

        if (isset($matches[0]) && !empty($matches[0])) {

            return preg_replace(['/#/', '/\n/'], ['', ''], $matches[0][0]);
        }
        return null;
    }

}
