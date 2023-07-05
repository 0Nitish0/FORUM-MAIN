<div class="px-2 py-1 text-xs text-black-500 transition duration-100 bg-red-300 rounded hover:bg-red-400">
    <a wire:click="confirmReplyDeletion" wire:loading.attr="disabled" class="cursor-pointer">
        Delete
    </a>

    <x-jet-dialog-modal wire:model="confirmingReplyDeletion">
        <x-slot name="title">
            {{ __("Delete Reply") }}
        </x-slot>
        <x-slot name="content">
            {{ __("Are you sure you want to delete the Reply?") }}
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingReplyDeletion')" wire:loading.attr="disabled">
                {{ __("Cancel") }}
            </x-jet-secondary-button>
            <x-jet-danger-button wire:click="deleteReply" wire:loading.attr="disabled">
                {{ __('Delete Reply') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
