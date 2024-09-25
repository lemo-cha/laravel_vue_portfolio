<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="text-sm text-red-600">
            {{ message }}
        </p>
    </div>
</template>

<style scoped lang="scss">
@import "resources/css/_variables.scss";
.c-message__error{
    display: block;
    font-size: $font-size_m;
    color: $error-color;
}
</style>