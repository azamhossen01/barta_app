<!-- resources/views/components/confirm-delete.blade.php -->

<div x-data="{ isOpen: false }">
    <template x-if="isOpen">
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto">
            <div class="fixed inset-0 bg-black opacity-50"></div>
            <div class="relative bg-white p-8 max-w-md mx-auto rounded-md shadow-lg">
                <p class="text-xl font-semibold mb-4">Are you sure you want to delete this record?</p>
                <div class="flex justify-end">
                    <button @click="isOpen = false" class="text-gray-600 mr-2">Cancel</button>
                    <button @click="deleteRecord()" class="text-red-600">Delete</button>
                </div>
            </div>
        </div>
    </template>

    <a href="javascript:void(0)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" @click="isOpen = true" id="user-menu-item-1">Delete</a>

    <form id="deleteForm" action="{{ $deleteRoute }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function deleteRecord() {
            document.getElementById('deleteForm').submit();
        }
    </script>
</div>
