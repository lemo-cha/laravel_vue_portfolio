<template>
    <button
        class="c-button c-button__danger"
    >
        <slot />
    </button>
</template>

<style scoped lang="scss">
@use 'resources/css/_button.scss';
</style>

<!-- <style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
.c-button__danger {
    position: relative;
    display: inline-flex;
    align-items: center;
    padding: $space_sm $space_md;
    background-color: $error-color;
    border: 1px solid transparent;
    border-radius: $radius_md;
    font-weight: 600;
    font-size: $font-size_s;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #ffffff;
    transition: background-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;

    &:hover {
        background-color: #ef4444;
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
        border: 2px solid rgba(239, 68, 68, 0.5);
        pointer-events: none;
    }
}
</style> -->