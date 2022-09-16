<ul class="{{ isset($type) && $type == 'children' ? 'ml-3' : 'py-3' }}">
    @foreach ($navigation as $element)
        @if ($element['type'] == 'folder')
            <li class="">
                <div class="flex justify-between group">
                    <span class="flex items-center gap-1 my-3 font-bold tracking-wider text-gray-400 uppercase">
                        <x-icon.folder />{{ $element['title'] }}
                    </span>
                    <button wire:click="deleteFolder('{{ $element['path'] }}')" type="button"
                        class="hidden text-gray-400 hover:text-red-500 group-hover:flex">
                        <x:component::icon.delete />
                    </button>
                </div>

                @if (isset($element['data']) && !empty($element['data']))
                    @include('documentation::template.navigation', [
                        'navigation' => $element['data'],
                        'type' => 'children',
                    ])
                @endif
            </li>
        @else
            <li class="flex justify-between gap-2 py-3 text-gray-500 cursor-pointer hover:text-teal-500 group">
                <button wire:click="select('{{ $element['path'] }}')" type="button" class="flex items-center gap-1 ">
                    <x-icon.file />{{ $element['title'] }}
                </button>
                <button wire:click="deleteFile('{{ $element['path'] }}')" type="button"
                    class="hidden text-gray-400 hover:text-red-500 group-hover:flex">
                    <x:component::icon.delete />
                </button>
            </li>
        @endif
    @endforeach
</ul>
