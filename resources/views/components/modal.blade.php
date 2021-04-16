<div  > 
    {{ $button }}
    <div
        
        x-on:close.stop="show = false"
        x-on:keydown.escape.window="show = false"        
        x-show="show"        
        class="fixed top-0 inset-x-0 px-4 pt-6 z-50 sm:px-0 sm:flex sm:items-top sm:justify-center"
        style="display: none;">
       
        <div 
            x-show="show" 
            class="fixed inset-0 transform transition-all" x-on:click="show = false" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div 
            x-show="show" 
            class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl "
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <!--laoding -->
            <div wire:loading.flex> 
                <div class="absolute inset-0 bg-gray-500 opacity-25"></div>          
                <div class='flex  items-center justify-center absolute inset-0 '>
                    <div class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-gray-600 ">                
                    
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                            <span>Processing  </span>              
                    </div>
                </div>
                
            </div>

            <!--modal-->
            <div class="px-6 py-4">
                <div class="text-lg">
                    {{ $title }}
                </div>

                <div class="mt-4 content-modal" wire:loading.class="invisible">
                    {{ $content }}
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-100 text-right">
                {{ $footer }}
            </div>
        </div>
    </div>
</div>