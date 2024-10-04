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
@import "resources/css/_variables.scss";
.c-link {
    display: inline-flex;
    align-items: center;
    padding: $space_xs $space_sm;
    border-bottom: 2px solid transparent;
    font-size: $font-size_m;
    font-weight: $font-weight_m;
    line-height: $line-height_sm;

    &--active {
        border-bottom-color: $accent-color;
        color: #1f2937; // gray-900
    }

    &:not(&--active) {
        color: #6b7280; // gray-500

        &:hover {
            color: #374151; // gray-700
            border-bottom-color: #d1d5db; // gray-300
        }

        &:focus {
            color: #374151; // gray-700
            border-bottom-color: #d1d5db; // gray-300
            outline: none;
        }
    }
}

</style>