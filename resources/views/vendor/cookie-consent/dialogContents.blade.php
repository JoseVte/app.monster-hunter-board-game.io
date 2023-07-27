<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-2 z-60">
    <div class="max-w-7xl mx-auto px-6">
        <div class="p-2 rounded-lg bg-gray-200 dark:bg-gray-800">
            <div class="flex items-center justify-between gap-4 flex-col sm:flex-row flex-wrap">
                <div class="flex-1 items-center inline">
                    <p class="ml-3 text-black dark:text-white cookie-consent__message">
                        {!! trans('cookie-consent::texts.message') !!}
                    </p>
                </div>
                <div class="flex-shrink-0 mt-0 w-auto sm:mx-4 md:mx-0">
                    <button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-gray-800 dark:text-gray-200 bg-gray-400 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-700">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
