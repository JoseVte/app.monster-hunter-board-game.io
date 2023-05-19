import {usePage} from "@inertiajs/vue3";

export function getQuery() {
    return usePage().props.ziggy.query;
}
