@extends('error')

@section('content')
    <div class="flex flex-col items-center justify-center max-w-lg md:max-w-xl lg:max-w-4xl w-full mx-6 my-8 sm:my-0">
        <div class="mb-4">
            <svg class="mx-auto mb-4 w-10 h-10 text-gray-400 dark:text-gray-600" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 512 512">
                <path fill="currentColor"
                      d="M331.8 224.1c28.29 0 54.88 10.99 74.86 30.97l19.59 19.59c40.01-17.74 71.25-53.3 81.62-96.65c5.725-23.92 5.34-47.08 .2148-68.4c-2.613-10.88-16.43-14.51-24.34-6.604l-68.9 68.9h-75.6V97.2l68.9-68.9c7.912-7.912 4.275-21.73-6.604-24.34c-21.32-5.125-44.48-5.51-68.4 .2148c-55.3 13.23-98.39 60.22-107.2 116.4C224.5 128.9 224.2 137 224.3 145l82.78 82.86C315.2 225.1 323.5 224.1 331.8 224.1zM384 278.6c-23.16-23.16-57.57-27.57-85.39-13.9L191.1 158L191.1 95.99l-127.1-95.99L0 63.1l96 127.1l62.04 .0077l106.7 106.6c-13.67 27.82-9.251 62.23 13.91 85.39l117 117.1c14.62 14.5 38.21 14.5 52.71-.0016l52.75-52.75c14.5-14.5 14.5-38.08-.0016-52.71L384 278.6zM227.9 307L168.7 247.9l-148.9 148.9c-26.37 26.37-26.37 69.08 0 95.45C32.96 505.4 50.21 512 67.5 512s34.54-6.592 47.72-19.78l119.1-119.1C225.5 352.3 222.6 329.4 227.9 307zM64 472c-13.25 0-24-10.75-24-24c0-13.26 10.75-24 24-24S88 434.7 88 448C88 461.3 77.25 472 64 472z"/>
            </svg>

            <h1 class="text-5xl font-extrabold text-blue-600 dark:text-blue-400">404</h1>
        </div>
        <h3 class="mb-3 text-2xl font-bold text-center text-gray-700 dark:text-gray-300">
            <p>{{ __('Something’s missing.') }}</p>
        </h3>
        <div class="text-sm mb-3 text-center text-gray-600 dark:text-gray-400">
            {{ __('Whoops! That page doesn’t exist.') }}
        </div>
        <form method="get" action="/search" class="flex flex-col sm:flex-row items-center gap-3 mb-3 w-full lg:max-w-2xl">
            <div class="relative w-full">
                <div class="flex items-center pl-3 absolute inset-0 pointer-events-none">
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-400"
                         fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                              clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input aria-label="search" type="search" autocomplete="search"
                       class="p-3 pl-10 w-full block text-sm border border-gray-400 dark:border-gray-600 bg-gray-200 dark:bg-gray-800 dark:text-gray-300 focus:ring focus:outline-none focus:border-sky-500 dark:focus:border-sky-600 focus:ring-sky-500 dark:focus:ring-sky-600 rounded-md shadow-sm"/>
            </div>
            <button type="submit"
                    class="font-semibold w-full sm:w-auto text-sm text-center px-5 py-3 bg-sky-800 dark:bg-sky-200 border border-transparent rounded-md h-full text-white dark:text-sky-800 uppercase tracking-widest hover:bg-sky-700 dark:hover:bg-white focus:bg-sky-700 dark:focus:bg-white active:bg-sky-900 dark:active:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-sky-800 transition ease-in-out duration-150"
            >{{ __('Submit') }}</button>
        </form>
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 mt-4 sm:mt-8 w-full">
            <a href="{{ route('dashboard') }}"
               class="p-6 block w-full text-center border border-gray-400 dark:border-gray-600 bg-gray-200 dark:bg-gray-800 hover:bg-gray-400 hover:dark:bg-gray-500 rounded-md shadow-sm">
                <div
                    class="bg-sky-100 dark:bg-sky-900 rounded flex items-center justify-center h-10 w-10 mb-4 mx-auto">
                    <svg
                        class="h-5 w-5 text-sky-600 dark:text-sky-400"
                        aria-hidden="true"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                        />
                    </svg>
                </div>
                <h3 class="text-lg mb-2 text-gray-800 dark:text-gray-200">{{ __('Dashboard') }}</h3>
            </a>
            <a href="{{ route('wiki.weapon.index') }}"
               class="p-6 block w-full text-center border border-gray-400 dark:border-gray-600 bg-gray-200 dark:bg-gray-800 hover:bg-gray-400 hover:dark:bg-gray-500 rounded-md shadow-sm">
                <div
                    class="bg-teal-100 dark:bg-teal-900 rounded flex items-center justify-center h-10 w-10 mb-4 mx-auto">
                    <svg
                        class="h-5 w-5 text-teal-600 dark:text-teal-400"
                        id="Capa_1"
                        fill="none"
                        stroke="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                        x="0px"
                        y="0px"
                        viewBox="0 0 512 512"
                        style="enable-background:new 0 0 512 512;"
                        xml:space="preserve"
                        width="512"
                        height="512"
                    >
                    <g>
                        <path
                            stroke-width="20"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-miterlimit="10"
                            d="&#10;&#9;&#9;M126.305,355.009l-92.893,81.894c-9.241,8.136-10.12,22.337-1.984,31.578l22.904,25.966c8.136,9.241,22.337,10.12,31.578,1.984&#10;&#9;&#9;l92.893-81.894"
                        />
                        <path
                            stroke-width="20"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-miterlimit="10"
                            d="&#10;&#9;&#9;M206.895,446.4L98.213,323.148c-5.017-5.698-4.479-14.485,1.219-19.503l28.545-25.172c5.698-5.017,14.485-4.479,19.503,1.219&#10;&#9;&#9;l108.682,123.252c5.017,5.698,4.479,14.485-1.219,19.503l-28.545,25.172C220.672,452.636,211.913,452.097,206.895,446.4&#10;&#9;&#9;L206.895,446.4z"
                        />

                        <polyline
                            stroke-width="20"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-miterlimit="10"
                            points="&#10;&#9;&#9;154.113,287.204 468.508,10 486.14,186.799 249.529,395.432 &#9;"
                        />

                        <polygon
                            stroke-width="20"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-miterlimit="10"
                            points="&#10;&#9;&#9;211.431,352.203 154.113,287.204 411.503,60.259 422.076,166.446 &#9;"
                        />

                        <line
                            stroke-width="20"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-miterlimit="10"
                            x1="117.404"
                            y1="468.652"
                            x2="64.934"
                            y2="409.123"
                        />

                        <line
                            stroke-width="20"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-miterlimit="10"
                            x1="225.547"
                            y1="281.96"
                            x2="225.576"
                            y2="282.016"
                        />

                        <line
                            stroke-width="20"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-miterlimit="10"
                            x1="262.852"
                            y1="249.049"
                            x2="262.909"
                            y2="249.077"
                        />

                        <line
                            stroke-width="20"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-miterlimit="10"
                            x1="300.185"
                            y1="216.138"
                            x2="300.213"
                            y2="216.167"
                        />
                    </g>
                </svg>
                </div>
                <h3 class="text-lg mb-2 text-gray-800 dark:text-gray-200">{{ __('Weapons') }}</h3>
            </a>
            <a href="{{ route('wiki.monster.index') }}"
               class="p-6 block w-full text-center border border-gray-400 dark:border-gray-600 bg-gray-200 dark:bg-gray-800 hover:bg-gray-400 hover:dark:bg-gray-500 rounded-md shadow-sm">
                <div
                    class="bg-fuchsia-100 dark:bg-fuchsia-900 rounded flex items-center justify-center h-10 w-10 mb-4 mx-auto">
                    <svg
                        class="h-5 w-5 text-fuchsia-600 dark:text-fuchsia-400"
                        fill="currentColor"
                        enable-background="new 0 0 512.094 512.094"
                        height="512"
                        viewBox="0 0 512.094 512.094"
                        width="512"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <g>
                            <path
                                d="m500.651 195.703c-16.764-63.324-48.54-108.301-73.26-135.621 3.391-25.518-28.938-46.629-46.702-58.207-9.112-6.005-20.606 3.763-16.267 13.747h.001c5.107 11.989 9.289 30.323 12.648 45.055 1.125 7.417 5.036 14.591 11.909 18.104 4.914 99.503-33.202 146.02-68.254 167.715-1.266-1.131-2.555-2.243-3.887-3.314v-12.239c35.251-21.931 20.521-67.968 11.956-82.502-3.009-4.15-6.715-4.91-11.115-2.282l-9.646 7.417c2.099-4.861 3.836-7.819 3.884-7.899 3.236-5.399-1.403-11.604-6.819-11.347-13.617.703-24.601 5.624-32.646 14.627-7.261 8.127-10.764 18.11-12.403 26.841h-8.359c-1.639-8.731-5.141-18.714-12.403-26.841-8.045-9.003-19.028-13.924-32.646-14.627-5.428-.275-10.05 5.978-6.812 11.359.047.077 1.696 2.861 3.721 7.476l-9.111-7.006c-4.401-2.628-8.106-1.868-11.115 2.282-8.668 14.788-23.215 60.577 11.956 82.502v12.239c-1.332 1.071-2.621 2.183-3.887 3.314-35.458-21.941-73.821-69.122-68.109-170.326 4.593-3.815 7.201-9.659 7.97-15.492 3.359-14.732 7.541-33.066 12.648-45.055h.001c4.332-9.979-7.144-19.755-16.269-13.746-33.46 22.741-50.535 40.16-45.973 61.65-16.694 19.01-31.234 40.191-43.256 63.03-4.403 8.365 8.799 15.486 13.273 6.987 10.936-20.775 24.053-40.1 39.041-57.56 4.6 3.307 11.495 5.671 17.292 5.432-2.185 75.076 14.833 136.684 72.802 176.119-7.36 8.977-13.046 19.133-16.876 29.968-37.292-23.508-59.92 10.09-66.947 42.723-8.369-11.883-20.565-25.143-33.345-24.987-35.312.376-37.096 50.336-36.85 74.877-18.087-74.772-15.447-144.669 7.976-208.515 3.34-9.103-10.741-14.271-14.082-5.166-33.956 94.298-23.903 190.27 14.04 287.803 3.18 8.081 16.049 4.577 14.341-4.184-4.102-21.012-23.688-129.817 14.789-129.817 8.218 0 22.826 19.739 30.232 34.028 3.343 6.464 13.352 4.583 14.12-2.654 2.139-25.956 15.892-76.432 51.633-48.783-1.493 8.146-1.983 16.52-1.404 24.936-35.287 8.389-51.762 50.241-34.266 81.312l32.818 58.284c-20.981-1.478-39.405 15.951-39.267 37.197 0 4.142 3.357 7.5 7.5 7.5h262.752c4.143 0 7.5-3.358 7.5-7.5.129-21.245-18.276-38.676-39.267-37.197l32.817-58.284c17.702-31.438.601-73.796-35.333-81.551.555-8.36.058-16.676-1.431-24.768 35.56-27.574 49.414 23.274 51.649 48.885.798 7.214 10.776 9.069 14.115 2.625 4.843-9.343 17.416-34.031 30.288-34.031 38.471.41 18.867 108.653 14.735 129.817-1.672 8.573 11.093 12.438 14.341 4.184 36.374-92.454 44.199-179.438 23.259-258.534zm-394.453-129.368c-24.218-5.878-1.855-29.531 19.707-45.073-3.669 11.51-6.702 24.81-9.272 36.082-.411 6.051-4.397 9.625-10.435 8.991zm276.225-45.074c21.657 15.403 44.017 39.887 19.707 45.074-6.09.64-9.757-3.046-10.435-8.992-2.57-11.272-5.603-24.572-9.272-36.082zm-168.213 183.346c11.733 17.147 41.106 7.645 38.833-13.809h5.66c-2.291 21.65 27.503 31.058 39.038 13.497 2.642 4.379 4.1 9.47 4.1 14.801v46.121c0 6.697-2.345 13.199-6.603 18.308l-20.881 25.048c-2.572 3.086-6.322 4.855-10.289 4.855h-16.013c-3.967 0-7.716-1.77-10.288-4.855l-20.881-25.048c-4.258-5.108-6.604-11.61-6.604-18.308v-46.121c0-5.185 1.397-10.17 3.928-14.489zm105.131-40.803c5.965 15.081 8.692 35.114-3.103 48.133-1.735-10.559-7.266-20.072-15.636-26.769.063-2.522.274-4.998.59-7.408zm-35.701-4.852c2.459-2.752 5.324-4.906 8.633-6.478-3.91 10.32-7.796 25.099-6.41 40.926.597 6.802-11.668 7.024-12.066.455-.228-3.734-.822-22.968 9.843-34.903zm-55.535 0c10.665 11.936 10.071 31.169 9.844 34.904-.398 6.568-12.663 6.346-12.066-.456 1.386-15.827-2.5-30.606-6.41-40.926 3.308 1.572 6.173 3.726 8.632 6.478zm-40.034 23.097c.84-7.004 2.87-13.473 4.718-18.24l17.738 13.639c.348 2.6.576 5.28.629 8.016-8.148 6.678-13.55 16.093-15.268 26.466-6.733-7.552-9.312-17.421-7.817-29.881zm-35.439 300.337 17.193-.097c5.224-.03 9.396-6.025 6.493-11.18l-39.073-69.392c-7.491-13.304-6.309-29.842 1.44-42.865 7.187-12.079 21.962-15.927 21.962-15.927l29.583 131.478c-7.366 5.376-12.684 13.396-14.54 22.655h-41.674c2.822-7.947 9.987-13.894 18.616-14.672zm69.191 14.673h-30.619c3.019-8.592 11.215-14.77 20.825-14.77h12.836c9.61 0 17.807 6.177 20.825 14.77zm44.611 0c3.019-8.592 11.214-14.77 20.824-14.77h12.836c9.61 0 17.807 6.177 20.825 14.77zm90.808-152.766c21.881 9.15 30.183 37.059 18.716 57.426l-39.072 69.392c-2.902 5.155 1.269 11.15 6.493 11.18l17.192.097c8.629.777 15.794 6.725 18.616 14.673h-42.755c-1.855-9.259-7.174-17.278-14.54-22.655l11.679-51.905c2.128-9.46-12.504-12.753-14.635-3.293l-11.009 48.924c-6.705-1.449-14.013-.869-20.827-.837v-100.379c0-4.142-3.357-7.5-7.5-7.5s-7.5 3.358-7.5 7.5v103.627c-6.593 2.968-12.165 7.805-16.04 13.837-3.875-6.032-9.447-10.869-16.04-13.837v-103.627c0-4.142-3.357-7.5-7.5-7.5s-7.5 3.358-7.5 7.5v100.377c-6.769-.031-14.184-.599-20.828.837l-28.912-128.497c-6.172-27.43 1.608-55.736 20.001-75.914-.486 10.376 3.455 21.46 10.082 29.409l20.881 25.048c5.43 6.514 13.379 10.25 21.81 10.25 14.52-.218 27.199 2.394 37.823-10.251 0 0 20.882-25.049 20.882-25.049 6.816-8.178 10.234-18.827 10.08-29.409 34.291 39.598 20.481 73.597 10.06 118.651-2.136 9.185 12.386 12.967 14.61 3.399 3.36-14.444 6.89-28.858 10.069-43.343 1.916.473 3.809 1.092 5.664 1.869zm128.085 35.704c.237-24.626-1.589-74.382-36.851-74.758-14.442-.215-25.971 14.625-33.306 25.081-7.368-32.169-29.85-66.439-67.009-42.882-3.83-10.812-9.509-20.946-16.855-29.906 58.046-39.519 75.005-101.101 72.791-176.331 5.678-.679 11.383-3.09 15.752-7.019 67.29 72.933 95.065 196.617 65.478 305.815z"
                            />
                            <path
                                d="m424.48 109.316c-3.976 1.163-6.256 5.328-5.093 9.304 9.367 32.023 11.379 67.275 6.525 114.301-.969 9.375 13.908 11.359 14.92 1.54 5.063-49.05 2.89-86.076-7.049-120.052-1.162-3.974-5.327-6.257-9.303-5.093z"
                            />
                            <path
                                d="m429.347 259.819c-4.102-.533-7.869 2.364-8.402 6.473-1.619 12.48-5.465 25.238-5.533 25.463-2.751 9.023 11.496 13.731 14.348 4.373.174-.569 4.271-14.102 6.061-27.907.532-4.108-2.367-7.869-6.474-8.402z"
                            />
                            <path
                                d="m87.874 109.316c-3.981-1.165-8.142 1.119-9.304 5.093-9.938 33.977-12.111 71.002-7.048 120.052.972 9.434 15.93 8.23 14.92-1.54-4.854-47.026-2.842-82.278 6.524-114.301 1.164-3.975-1.116-8.141-5.092-9.304z"
                            />
                            <path
                                d="m83.008 259.819c-4.107.533-7.006 4.294-6.473 8.402 1.79 13.805 5.886 27.337 6.059 27.906 2.776 9.109 17.175 4.921 14.35-4.37-.039-.128-3.908-12.937-5.533-25.466-.533-4.107-4.295-7.001-8.403-6.472z"
                            />
                        </g>
                    </svg>
                </div>
                <h3 class="text-lg mb-2 text-gray-800 dark:text-gray-200">{{ __('Monsters') }}</h3>
            </a>
            <a href="{{ route('wiki.item.index') }}"
               class="p-6 block w-full text-center border border-gray-400 dark:border-gray-600 bg-gray-200 dark:bg-gray-800 hover:bg-gray-400 hover:dark:bg-gray-500 rounded-md shadow-sm">
                <div
                    class="bg-lime-100 dark:bg-lime-900 rounded flex items-center justify-center h-10 w-10 mb-4 mx-auto">
                    <svg
                        class="h-5 w-5 text-lime-600 dark:text-lime-400"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"
                        ></path>
                    </svg>
                </div>
                <h3 class="text-lg mb-2 text-gray-800 dark:text-gray-200">{{ __('Items') }}</h3>
            </a>
        </div>
    </div>
@endsection