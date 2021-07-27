<div x-show="errors.length" class="max-w-xl mx-auto w-full bg-red-100 rounded-md p-4 flex" x-transition.duration.500ms>
    <div>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                clip-rule="evenodd" />
        </svg>
    </div>
    <div class="px-4 flex-grow">
        <span class="text-red-700 font-semibold">Tienes Errores por revisar </span>
        <ul class="list-disc text-red-600">
            <template x-for="error in errors">
                <li x-text="error"></li>
            </template>
        </ul>
    </div>
    <div>
        <button x-on:click="errors=[]" class="outline-none focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>