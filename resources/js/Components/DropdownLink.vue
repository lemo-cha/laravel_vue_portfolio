<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="c-link"
    >
        <slot />
    </Link>
</template>
<style scoped lang="scss">
@import "resources/css/_variables.scss";
.c-link {
    display: block;
    width: 100%;
    padding: 0.5rem 1rem;
    text-align: start;
    font-size: $font-size_m;
    line-height: 1.25rem;
    color: rgb(55 65 81);

    &:hover {
        background-color: rgb(243 244 246);
    }

    &:focus {
        outline: none;
        background-color: rgb(243 244 246);
    }

    transition: background-color 0.15s ease-in-out;
}


</style>