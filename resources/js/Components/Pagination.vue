<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({ links: Array });
</script>

<template>
    <div v-if="links.length > 3" class="c-container">
        <div class="c-container__wrap">
            <template v-for="(link, index) in links" :key="index">
                <div
                v-if="link.url === null"
                class="c-container__wrap--item inactive-link"
                v-html="link.label"
                />
                <Link
                v-else
                class="c-container__wrap--item"
                :class="{ 'is-active': link.active }"
                :href="link.url"
                v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>
<style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
.c-container {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: -$space_xs;

    .c-container__wrap {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: -$space_xs;

        .c-container__wrap--item {
        margin-right: $space_xs;
        margin-bottom: $space_xs;
        padding: $space_sm $space_md;
        font-size: $font-size_m;
        line-height: $line-height_md;
        border: 1px solid $border_gray;
        border-radius: $radius_sm;
        transition: background-color 0.3s;

        &:hover {
            background-color: $border_gray; //borderの色と合わせる
        }
        &:focus {
            border-color: $accent_color;
            color: $accent_color;
        }

        &.is-active {
            background-color: $accent-color;
            color: $bg-color_content;
        }
        }
    }
}

</style>