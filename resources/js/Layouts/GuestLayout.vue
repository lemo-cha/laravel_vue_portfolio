<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="l-page">
        <div>
            <Link href="/">
                <ApplicationLogo class="l-logo" />
            </Link>
        </div>

        <div
            class="l-main"
        >
            <slot />
        </div>
    </div>
</template>
<style scoped lang="scss">
@import "resources/css/_variables.scss";
.l-page{
    display: flex;
    padding-top: $space_lg;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    //background: #f3f4f6; *画像を使用しない場合
    font-family: $font-default;
    background: 
        linear-gradient(rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.6)), 
        url(images/watercolor_00853_30722048.jpg) center / cover no-repeat fixed;
    @media #{map-get($breakpoints,'sm')}{
        padding-top: 0;
        justify-content: center;
    }
}
.l-logo{
    width: 5rem;
    height: auto;
}
.l-main{
    overflow: hidden;
    padding: $space_md $space_lg;
    margin-top: $space_lg;
    width: 100%;
    background: #ffffff;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1),0 2px 4px -1px rgba(0,0,0,0.06);
    @media #{map-get($breakpoints,'sm')}{
        border-radius: $radius_lg;
        max-width: 28rem;
    }
}
</style>