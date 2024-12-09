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

const classes = computed(() => {
    return {
        'c-link': true,
        'c-link--active': props.active,
    };
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
.c-link{
    display: inline-flex;
    align-items: center;
    padding: $space_xs $space_sm;
    border-bottom: 2px solid transparent;
    font-size: $font-size_m;
    font-weight: $font-weight_m;
    line-height: $line-height_sm;
    &--active{
        border-bottom-color: $accent-color;
        color: $font-color_default;
    }
    &:not(&--active) {
        color: $font-color_light;
        &:hover{
            color: $font-color_default;
            border-bottom-color: $border_gray;
        }
        &:focus{
            color: $font-color_default;
            border-bottom-color: $border_gray;
            outline: none;
        }
    }
}
</style>