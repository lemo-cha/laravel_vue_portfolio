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
@use 'resources/css/_variables.scss' as *;
.c-link{
    display: block;
    width: 100%;
    padding: $space_sm $space_md;
    text-align: start;
    font-size: $font-size_m;
    line-height: $line-height_sm;
    transition: background-color 0.15s ease-in-out;
    &:hover{
        background-color: $bg-active_gray;
    }
    &:focus{
        outline: none;
        background-color: $bg-active_gray;
    }
}
</style>