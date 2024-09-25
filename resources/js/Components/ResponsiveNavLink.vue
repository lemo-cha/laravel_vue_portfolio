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
$color-gray-50: #f9fafb;
$color-gray-300: rgb(209 213 219);
$color-gray-600: #4b5563;
$color-gray-800: #1f2937;
$color-indigo-50: #eef2ff;
$color-indigo-400: #6366f1;
$color-indigo-700: #4338ca;
$color-indigo-800: #3730a3;

.c-navlink {
  display: block;
  width: 100%;
  padding: 0.5rem 1rem;
  border-left: 4px solid transparent;
  text-align: start;
  font-size: 1rem;
  font-weight: 500;
  color: $color-gray-600;
  transition: all 0.15s ease-in-out;

  &--active {
    border-color: $color-indigo-400;
    color: $color-indigo-700;
    background-color: $color-indigo-50;
  }

  &:hover {
    color: $color-gray-800;
    background-color: $color-gray-50;
    border-color: $color-gray-300;
  }

  &:focus {
    outline: none;
    color: $color-gray-800;
    background-color: $color-gray-50;
    border-color: $color-gray-300;
  }
}


</style>
