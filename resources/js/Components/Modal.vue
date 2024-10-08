<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);

watch(
    () => props.show,
    () => {
        document.body.style.overflow = props.show ? 'hidden' : '';
    }
);

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = '';
});

// const maxWidthClass = computed(() => {
//     return {
//         sm: 'max-width-sm',
//         md: 'max-width-md',
//         lg: 'max-width-lg',
//         xl: 'max-width-xl',
//         '2xl': 'max-width-2xl',
//     }[props.maxWidth];
// });

</script>

<template>
    <Teleport to="body">
        <Transition name="fade">
            <div v-if="show" class="c-modal__overlay">
                <Transition name="fade">
                    <div class="c-modal__background" @click="close"></div>
                </Transition>

                <Transition name="fade">
                    <div class="c-modal__container">
                        <slot />
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
.c-modal {
    &__overlay {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow-y: auto;
        padding: $space_lg;
        z-index: 50;
        @media #{map-get($breakpoints, 'sm')} {
            padding: 0;
        }
    }
    &__background {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: $font-color_light;
        opacity: 0.75;
    }
        &__container {
        background: $bg-color_content;
        border-radius: $radius_lg;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); /* 中央に配置するためのtransform */
        z-index: 51;
        width: 90%;
        max-width: 100%;
        max-height: 80vh;
        overflow-y: auto;
        padding: $space_md;
        @media #{map-get($breakpoints, 'sm')} {
            width: auto;
            margin: 0 auto;
            max-width: 42rem;
        }
    }
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: scale(0.95);
}
.fade-enter-to,
.fade-leave-from {
    opacity: 1;
    transform: scale(1);
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease-out, transform 0.2s ease-out;
}
</style>