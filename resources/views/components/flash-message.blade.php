@if (session('error'))
<div id="flash-message" class="fixed top-4 right-4 bg-white z-100 border-l-4 border-red-500 text-red-700 p-4 shadow-lg transition-all duration-300 ease-in-out transform" role="alert">
    <div class="flex items-center">
        <div class="py-1">
            <svg class="h-6 w-6 text-red-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="font-semibold text-red-700">Error</p>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 text-red-500 focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-100 inline-flex h-8 w-8 transition-colors" onclick="closeFlashMessage()">
            <span class="sr-only">Close</span>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</div>
@elseif (session('success'))
<div id="flash-message" class="fixed top-4 right-4 bg-white z-100 border-l-4 border-[#2563EB] text-blue-700 p-4 shadow-lg transition-all duration-300 ease-in-out transform" role="alert">
    <div class="flex items-center">
        <div class="py-1">
            <svg class="h-6 w-6 text-[#2563EB] mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="font-semibold text-blue-700">Success</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 text-blue-500 focus:ring-2 focus:ring-blue-400 p-1.5 hover:bg-blue-100 inline-flex h-8 w-8 transition-colors" onclick="closeFlashMessage()">
            <span class="sr-only">Close</span>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</div>
@elseif (session('warning'))
<div id="flash-message" class="fixed top-4 right-4 bg-white z-100 border-l-4 border-yellow-500 text-nextjob-black p-4 shadow-lg transition-all duration-300 ease-in-out transform" role="alert">
    <div class="flex items-center">
        <div class="py-1">
            <svg class="h-6 w-6 text-yellow-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div>
            <p class="font-semibold text-yellow-700">Warning</p>
            <p class="text-sm">{{ session('warning') }}</p>
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 text-yellow-500 focus:ring-2 focus:ring-yellow-400 p-1.5 hover:bg-yellow-100 inline-flex h-8 w-8 transition-colors" onclick="closeFlashMessage()">
            <span class="sr-only">Close</span>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</div>
@elseif (session('info'))
<div id="flash-message" class="fixed top-4 right-4 bg-white z-100 border-l-4 border-indigo-500 text-indigo-700 p-4 shadow-lg transition-all duration-300 ease-in-out transform" role="alert">
    <div class="flex items-center">
        <div class="py-1">
            <svg class="h-6 w-6 text-indigo-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="font-semibold text-indigo-700">Information</p>
            <p class="text-sm">{{ session('info') }}</p>
        </div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 text-indigo-500 focus:ring-2 focus:ring-indigo-400 p-1.5 hover:bg-indigo-100 inline-flex h-8 w-8 transition-colors" onclick="closeFlashMessage()">
            <span class="sr-only">Close</span>
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</div>
@endif

<script>
    // Auto-hide the flash message after 5 seconds
    setTimeout(function() {
        closeFlashMessage();
    }, 5000);

    function closeFlashMessage() {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.transform = 'translateY(-10px)';
            setTimeout(function() {
                flashMessage.style.display = 'none';
            }, 500);
        }
    }
</script>
