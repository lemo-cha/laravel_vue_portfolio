<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2>HOME</h2>
        </template>

        <div class="l-page">
            <div class="l-page__container">
                <div class="p-content">
                    <div class="p-content__text">Adminのダッシュボード</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped lang="scss">
@import "resources/css/_variables.scss";
/*----------------
---   Layout   ---
----------------*/
.l-page{
    padding: $space_3l 0;
}
.l-page__container{
    max-width: 80rem;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    row-gap: $space_lg;
    @media #{map-get($breakpoints,'sm')}{
        padding: 0 $space_lg;
    }
    @media #{map-get($breakpoints,'lg')}{
        padding: 0 $space_xl;
    }
}
/*-----------------
---   Project   ---
-----------------*/
.p-content{
    overflow: hidden;
    background: #ffffff;
    box-shadow: $box-shadow-sm;
    @media #{map-get($breakpoints,'sm')}{
        border-radius: $radius_lg;
    }
}
.p-content__text{
    padding: $space_lg;
}
</style>