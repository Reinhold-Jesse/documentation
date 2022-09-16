<div>
    <x-slot name="header">
        <h2 class="font-semibold leading-tight ">
            {{ __('Dokumentation erstellen') }}
        </h2>
    </x-slot>

    <div class="container mx-auto">

        <div class="py-7">
            <x:component::form.label value="Child" />
            <div class="flex gap-5 ">
                <div class="w-full">

                    <x:component::form.select wire:model="child_folder" name="child" class="bg-gray-100">
                        <x:component::form.select-option value="" name="" />
                        @foreach ($folder_list as $folder)
                            <x:component::form.select-option value="{{ $folder['title'] }}"
                                name="{{ $folder['path'] }}" />
                        @endforeach
                    </x:component::form.select>

                </div>
                <button wire:click="save" type="button"
                    class="w-56 px-5 py-2 text-center text-white bg-teal-500 rounded-md hover:bg-teal-600">Erstellen</button>
            </div>
        </div>
        <div id="docsMarkdown">
            @livewire('markdown-x')
        </div>

    </div>
</div>
