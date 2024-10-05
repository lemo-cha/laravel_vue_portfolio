<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active ? 'c-navlink c-navlink--active' : 'c-navlink'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<style scoped lang="scss">
@import "resources/css/_variables.scss";
.c-navlink {
    display: block;
    width: 100%;
    padding: $space_sm $space_md;
    border-left: 4px solid transparent;
    text-align: start;
    font-size: $font-size_default;
    font-weight: $font-weight_m;
    color: #4b5563;
    transition: all 0.15s ease-in-out;
    &--active {
        border-color: $accent-color_light;
        color: $accent-color_dark;
        background-color: $accent-color_lightest;
    }
    &:hover {
        color: $font-color_default;
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }
    &:focus {
        outline: none;
        color: $font-color_default;
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }
}
</style>
