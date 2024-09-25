<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        required: true,
    },
    value: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <input
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        class="c-checkbox"
    />
</template>

<style scoped lang="scss">
@import "resources/css/_variables.scss";

.c-checkbox{
    border-radius: 0.25rem;
    border: 1px solid #d1d5db;
    color: $accent-color;
    box-shadow: $box-shadow-sm;
    &:focus{
        outline: none;
        box-shadow: 0 0 0 2px rgba(99,102,241,0.5);
    }
}
</style>