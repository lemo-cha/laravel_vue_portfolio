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
@use 'resources/css/_variables.scss' as *;
.c-input{
    height: 2.625rem;
    padding: 0 $space_sm; 
    background: $bg-color_content;
    border-radius: $radius_md; 
    border: 1px solid $border_gray;
    box-shadow: $box-shadow-sm;
    &:focus{
        border-color: $accent-color_light;
        box-shadow: 0 0 0 1px rgba($accent-color_light, 1);
        outline: none;
    }
}
</style>