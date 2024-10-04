<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="c-label">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
<style scoped lang="scss">
@import "resources/css/_variables.scss";
.c-label{
    display: block;
    font-weight: $font-weight_m;
    font-size: $font-size_m;
}

</style>