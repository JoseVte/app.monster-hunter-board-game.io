<script setup>
defineProps({
    containerClass: String
})

const toggleDarkMode = () => {
    if (localStorage.getItem('color-theme') === 'light') {
        document.documentElement.classList.add('dark');
        document.documentElement.classList.remove('light');
        localStorage.setItem('color-theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        document.documentElement.classList.add('light');
        localStorage.setItem('color-theme', 'light');
    }

    const wysiwyg = document.getElementsByClassName("toastui-editor-defaultUI");
    for (const el of wysiwyg) {
        if (el.classList.contains("toastui-editor-dark")) el.classList.remove("toastui-editor-dark");
        else el.classList.add("toastui-editor-dark");
    }

    document.dispatchEvent(new CustomEvent('toggleDarkMode', {
        detail: {
            theme: localStorage.getItem('color-theme')
        }
    }))
}
</script>

<template>
    <div>
        <button
            type="button"
            class="flex justify-center p-2 text-gray-500 transition duration-150 ease-in-out
            bg-white border border-transparent rounded-md
            dark:bg-gray-800 dark:text-gray-200
            hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-300
            focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-900 active:bg-gray-50 dark:active:900"
            :class="containerClass"
            :title="$t('Toggle dark mode')"
            @click="toggleDarkMode()"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                class="block dark:hidden w-5 h-5 transform -rotate-90"
            >
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
            </svg>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                class="hidden dark:block w-5 h-5"
            >
                <path
                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                />
            </svg>
        </button>
    </div>
</template>

<style scoped>

</style>
