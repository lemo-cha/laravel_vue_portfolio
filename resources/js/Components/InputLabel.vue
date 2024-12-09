<script setup>
defineProps({
    value: {
        type: String,
    },
    caution: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <label class="c-label">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
        <span v-if="caution" class="c-label__caution">{{ '*' + caution }}</span>
    </label>
</template>

<style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
.c-label{
    display: block;
    font-weight: $font-weight_m;
    font-size: $font-size_m;
}
.c-label__caution{
    margin-left: $space_sm;
    font-size: $font-size_s;
}
</style>