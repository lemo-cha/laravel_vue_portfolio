<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="c-message__error">
            {{ message }}
        </p>
    </div>
</template>

<style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
.c-message__error{
    display: block;
    font-size: $font-size_m;
    color: $error-color;
}
</style>