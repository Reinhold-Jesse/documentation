<div>
    <x-slot name="header">
        <h2 class="font-semibold leading-tight ">
            {{ __('Dokumentation edit') }}
        </h2>
    </x-slot>

    <div class="container mx-auto">

        <div class="py-7">
            <div class="flex justify-end gap-5">
                <button wire:click="save" type="button"
                    class="w-56 px-5 py-2 text-center text-white bg-teal-500 rounded-md hover:bg-teal-600">Speichern</button>
            </div>
        </div>

        <div id="docsMarkdown">
            @livewire('markdown-x', ['content' => $content])
        </div>

    </div>
</div>
