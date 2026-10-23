// Shared by PrimaryButton and PrimaryLink, so a navigation styled as the
// primary button cannot drift from the button itself. A link that only looks
// like a button has to be an <a>: wrapping a <button> in one is invalid HTML
// and leaves keyboard users two tab stops for a single action.
export const primaryButtonClass =
    'mh-notch inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-gray-600 dark:border-gray-500 font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-hidden focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150';
