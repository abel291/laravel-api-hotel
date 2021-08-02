<div>
    @if($button_back_step)
    <x-jet-secondary-button x-on:click="step={{$button_back_step}};scroll_top()">
        volver
    </x-jet-secondary-button>
    @endif
</div>

@if ($step_alpine_fuction)
    <div>
        <button x-on:click="{{$step_alpine_fuction}}" id="{{$step_alpine_fuction}}"
            class=" w-56 flex items-center justify-center py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:shadow-outline-gray"
            :class="{ 'bg-gray-500 cursor-default' : isLoading , 'bg-gray-800 hover:bg-gray-600' : ! isLoading }" :disabled="isLoading">

            <span class="text-white" x-show="!isLoading">{{$text}}</span>

            <div x-show="isLoading">
                <div class="flex items-center justify-center ">
                    <div>
                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-white">{{$text_loading}}</span>

                </div>
            </div>

        </button>
    </div>
@endif