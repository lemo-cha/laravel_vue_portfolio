<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="c-input"
        v-model="model"
        ref="input"
    />
</template>
<style scoped lang="scss">
@import "resources/css/_variables.scss";
.c-input{
    border-radius: 0.375rem; 
    border-color: #D1D5DB; 
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    &:focus{
        border-color: #6366f1;
        box-shadow: 0 0 0 1px rgba(99, 102, 241, 1);
        outline: none;
    }
}
</style>