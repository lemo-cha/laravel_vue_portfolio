<template>
    <button
        class="c-button c-button__primary"
    >
        <slot />
    </button>
</template>
<style scoped lang="scss">
@use 'resources/css/_button.scss';
</style>

<!-- <style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
.c-button__primary {
    position: relative;
    display: inline-flex;
    align-items: center;
    padding: $space_sm $space_md;
    background-color: #1f2937;
    border: 1px solid transparent;
    border-radius: $radius_md;
    font-weight: 600;
    font-size: $font-size_s;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #ffffff;
    transition: background-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;

    &:hover {
        background-color: #374151;
    }

    &:focus {
        outline: none;
    }

    &:focus::before {
        content: '';
        position: absolute;
        top: -4px;
        right: -4px;
        bottom: -4px;
        left: -4px;
        border-radius: $radius_lg;
        border: 2px solid rgba(99, 102, 241, 0.5);
        pointer-events: none;
    }
}
</style> -->
