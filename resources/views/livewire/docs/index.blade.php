<div class="">
    <x-slot name="header">
        <h2 class="font-semibold leading-tight ">
            {{ __('Dokumentation') }}
        </h2>
    </x-slot>

    <div x-data="{ open: false }" class="container ">
        <div class="flex">
            <div class="w-3/12 bg-gray-200 px-7 py-7">
                <div class="flex justify-end gap-2">
                    <a href="{{ route('package.docs.create') }}" class="text-gray-400 hover:text-primary-500">
                        <x-icon.file />
                    </a>

                    <button @click.prevent="open = true" type="button" class="text-gray-400 hover:text-primary-500">
                        <x-icon.folder />
                    </button>
                </div>
                <nav class="">
                    @include('documentation::template.navigation', [
                        'navigation' => $navigation,
                    ])
                </nav>
            </div>
            <div class="w-9/12 px-10 py-10 bg-white">

                @if (isset($content) && !empty($content))
                    <div class="flex justify-end">
                        <a href="{{ route('package.docs.edit', $select_file) }}"
                            class="flex items-center justify-center border-2 rounded-md shadow-sm text-primary-500 border-primary-500 hover:text-white w-9 h-9 hover:bg-primary-500 default-transition">
                            <x:component::icon.edit />
                        </a>
                    </div>
                    <div id="docsMarkdown">
                        {!! Str::markdown($content) !!}
                    </div>
                @endif


            </div>
        </div>
        <div x-cloak x-show="open"
            class="fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center px-5 bg-gray-500 backdrop-blur-sm bg-opacity-70"
            x-transition:enter="transition ease-out duration-100 transform"
            x-transition:enter-start="opacity-0 scale-30" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div @click.outside="open = false" class="overflow-hidden bg-white rounded-md w-96">
                <div class="p-5 pt-7">
                    <div>
                        <x:component::form.label value="Ordner name" />
                        <x:component::form.input wire:model="new_folder" name="folder" class="bg-gray-100" />
                    </div>
                    <div class="mt-5">
                        <x:component::form.label value="Child" />
                        <x:component::form.select wire:model="child_folder" name="child" class="bg-gray-100">
                            <x:component::form.select-option value="" name="" />
                            @foreach ($folder_list as $folder)
                                <x:component::form.select-option value="{{ $folder['title'] }}"
                                    name="{{ $folder['path'] }}" />
                            @endforeach
                        </x:component::form.select>

                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 px-4 text-right bg-gray-100 py-7 sm:px-6">
                    <button @click.prevent="open=false" type="button"
                        class="flex justify-center w-full px-4 py-2 mr-2 font-medium text-center text-white bg-gray-300 border border-transparent rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Abbrechen</button>

                    <button wire:click="createNewFolder" @click.prevent="open=false" type="button"
                        class="flex justify-center w-full px-4 py-2 font-medium text-center text-white border border-transparent rounded-md shadow-sm bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">erstellen</button>
                </div>
            </div>
        </div>
    </div>
</div>
