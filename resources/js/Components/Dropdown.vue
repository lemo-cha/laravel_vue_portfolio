<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    align: {
        type: String,
        default: 'right',
    },
    width: {
        type: String,
        default: '48',
    },
    contentClasses: {
        type: String,
        default: 'c-dropdown__content-inner',
    },
});

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
    return {
        48: 'c-dropdown--width-48',
    }[props.width.toString()];
});

const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'c-dropdown--align-left';
    } else if (props.align === 'right') {
        return 'c-dropdown--align-right';
    } else {
        return 'c-dropdown--align-center';
    }
});

const open = ref(false);
</script>

<template>
    <div class="c-dropdown">
        <div @click="open = !open">
            <slot name="trigger" />
        </div>

        <div v-show="open" class="c-dropdown__overlay" @click="open = false"></div>

        <Transition>
            <div
                v-show="open"
                class="c-dropdown__content"
                :class="[widthClass, alignmentClasses]"
                style="display: none"
                @click="open = false"
            >
                <div class="c-dropdown__content-inner" :class="contentClasses">
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>

<style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
.c-dropdown{
    position: relative;
    &__overlay{
        position: fixed;
        inset: 0;
        z-index: 40;
    }
    &__content{
        position: absolute;
        z-index: 50;
        margin-top: $space_sm;
        border-radius: $radius_md;
        box-shadow: $box-shadow-sm;
    }
    &__content-inner{
        padding: $space_xs 0;
        background-color: $bg-color_content;
        border-radius: $radius_md;
        box-shadow: $box-shadow-sm;
    }
    &--width-48{
        width: 12rem;
    }
    &--align-left{
        transform-origin: top left;
        left: 0;
    }
    &--align-right{
        transform-origin: top right;
        right: 0;
    }
    &--align-center{
        transform-origin: top center;
    }
}
.v-enter-from,.v-leave-to{
    opacity: 0;
    transform: scale(0.95);
}
.v-enter-to,.v-leave-from{
    opacity: 1;
    transform: scale(1);
}
.v-enter-active, .v-leave-active{
    transition: opacity 0.2s ease-out, transform 0.2s ease-out;
}
</style>