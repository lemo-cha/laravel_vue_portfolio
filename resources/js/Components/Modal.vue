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

const maxWidthClass = computed(() => {
    return {
        sm: 'max-width-sm',
        md: 'max-width-md',
        lg: 'max-width-lg',
        xl: 'max-width-xl',
        '2xl': 'max-width-2xl',
    }[props.maxWidth];
});
</script>

<template>
    <Teleport to="body">
        <Transition name="fade">
            <div v-show="show" class="c-modal__overlay">
                <Transition name="fade">
                    <div v-show="show" class="c-modal__background" @click="close"></div>
                </Transition>

                <Transition name="fade">
                    <div class="c-modal__container" :class="maxWidthClass">
                        <slot v-if="show" />
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
<style scoped lang="scss">
@import "resources/css/_variables.scss";
.c-modal {
    &__overlay {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow-y: auto;
        z-index: 50;
        background-color: rgba(60, 64, 68, 0.75); // オーバーレイは透ける
    }

    &__background {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: transparent; // 透ける背景を追加
    }

    &__container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); // モーダルを中央に配置
        background-color: #ffffff; // モーダルの背景色
        z-index: 51; // オーバーレイより上に表示
        border-radius: $radius_lg; // 丸みをつける
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1); // シャドウを追加
        font-family: $font-default;

        // 最大幅のクラス
        &.max-width-sm {
            max-width: 24rem; // sm
        }
        &.max-width-md {
            max-width: 28rem; // md
        }
        &.max-width-lg {
            max-width: 32rem; // lg
        }
        &.max-width-xl {
            max-width: 36rem; // xl
        }
        &.max-width-2xl {
            max-width: 42rem; // 2xl
        }
    }
}

// トランジション用
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0;
}

</style>