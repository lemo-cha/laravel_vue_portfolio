<script setup>
import { toRefs } from 'vue';
import { computed } from 'vue';

const props = defineProps({
    modelValue: [String, Number], // 親コンポーネントからの v-model を受け取る
    options: {
        type: Array,
        required: true, // 親からの選択肢リスト
    },
});

const { modelValue, options } = toRefs(props);
const emits = defineEmits(['update:modelValue']);

// v-model の双方向データバインディング
const selectedValue = computed({
    get: () => modelValue.value,
    set: (value) => emits('update:modelValue', value),
});
</script>
<template>
    <select v-model="selectedValue" class="c-select" required autofocus>
        <option value="">
            選択してください
        </option>
        <option v-for="(option, index) in options" :key="index" :value="option.id">
            {{ option.value }}
        </option>
    </select>
</template>

<style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
.c-select{
    height: 2.625rem;
    padding: 0 0.5rem; 
    background: $bg-color_content;
    border-radius: $radius_md; 
    border: 1px solid $border_gray;
    box-shadow: $box-shadow-sm;
    font-size: 1rem;
    &:focus{
        border-color: $accent-color_light;
        box-shadow: 0 0 0 1px rgba($accent-color_light, 1);
        outline: none;
    }
}
</style>

<!-- <select 
    name="company_type"
    class="p-content__form-input-field"
    v-model="form.company_type"
    required
    autofocus
    >
    <option value="">
        選択してください
    </option>
    <option v-for="(company_type) in company_types" :key="company_type.id" :value="company_type.id">
        {{ company_type.value }}
    </option>
</select> -->