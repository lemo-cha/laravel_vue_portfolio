<template>
    <button
        class="c-button__primary"
    >
        <slot />
    </button>
</template>
<style scoped lang="scss">
@import "resources/css/_variables.scss";
.c-button__primary {
    position: relative;
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background-color: #1f2937;
    border: 1px solid transparent;
    border-radius: 0.375rem;
    font-weight: 600;
    font-size: 0.75rem;
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
        border-radius: 0.5rem;
        border: 2px solid rgba(99, 102, 241, 0.5);
        pointer-events: none;
    }
}
</style>
