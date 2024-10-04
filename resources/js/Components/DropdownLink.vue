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
    padding: $space_sm $space_md;
    text-align: start;
    font-size: $font-size_m;
    line-height: $line-height_sm;
    color: #374151;

    &:hover {
        background-color: #f3f4f6;
    }

    &:focus {
        outline: none;
        background-color: #f3f4f6;
    }

    transition: background-color 0.15s ease-in-out;
}


</style>