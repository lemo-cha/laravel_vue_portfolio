<script setup>
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    products:{
        type: Object,
        default: [],
    }
})

const showModal = ref(false);
const selectedProduct = ref({});

const showProductModal = (product) => {
    showModal.value = true;
    selectedProduct.value = product;
}
const closeModal = () => {
    showModal.value = false;
}
const createProduct = () => {
    router.get(route('products.create'));
}
const showProduct = (id) => {
    router.get(route('products.show',{product: id}));
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="u-title-container">
            <h2>商品</h2> <!-- ***1 文字数に変更があればスタイル要編集 -->
            <PrimaryButton @click="createProduct" class="u-title-container__button">登録</PrimaryButton>
            </div>
        </template>

        <div class="l-page">
            <div class="l-page__container">
                <div class="p-content__sub">
                    <div class="p-search-box">
                        <p>検索</p>
                    </div>
                </div>
                <div class="p-content__main">
                    <div class="p-content__text">
                        <div v-for="product in products.data" :key="product.id" @click="showProductModal(product)" class="p-product__container">
                            <img class="p-product__container--image" :src="product.image_1" alt="">
                            <p class="p-product__container--category">
                                {{ product.category }}
                            </p>
                            <p class="p-product__container--maker">
                                {{ product.maker }}
                            </p>
                            <p class="p-product__container--name">
                                {{ product.name }}
                            </p>
                            <p class="p-product__container--size">
                                {{ product.size }}
                            </p>
                            <p class="p-product__container--status">
                                {{ product.status }}
                            </p>
                        </div>
                    </div>
                    <Pagination :links="products.links" class="p-paginate" />
                </div>
                <Modal :show="showModal">
                    <div class="p-modal">
                        <h2 class="p-modal__title">
                            詳細表示
                        </h2>

                        <div class="p-modal__text">
                            <div class="p-modal__left">
                                <img class="p-modal__left--image" :src="selectedProduct.image_1" alt="">
                            </div>
                            <div class="p-modal__right">
                                <p class="p-modal__right--category">
                                    {{ selectedProduct.category }}
                                </p>
                                <p class="p-modal__right--maker">
                                    {{ selectedProduct.maker }}
                                </p>
                                <p class="p-modal__right--name">
                                    {{ selectedProduct.name }}
                                </p>
                                <p class="p-modal__right--size">
                                    {{ selectedProduct.size }}
                                </p>
                                <p class="p-modal__right--product_number">
                                    {{ selectedProduct.product_number }}
                                </p>
                                <p class="p-modal__right--description">
                                    {{ selectedProduct.description }}
                                </p>
                                <p class="p-modal__right--status">
                                    {{ selectedProduct.status }}
                                </p>
                                <p class="p-modal__right--status_description">
                                    {{ selectedProduct.status_description }}
                                </p>
                            </div>
                        </div>
                        <div class="p-modal__button">
                            <SecondaryButton @click="closeModal"> 閉じる </SecondaryButton>

                            <PrimaryButton
                                class="u-button"
                                @click="showProduct(selectedProduct.id)"
                            >
                                詳細ページを開く
                            </PrimaryButton>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
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
    flex-direction: row;
    gap: $space_lg;
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
.p-content__sub{
    width: 30%;
    overflow: hidden;
    background: $bg-color_content;
    padding: $space_xl;
    box-shadow: $box-shadow-sm;
    @media #{map-get($breakpoints,'sm')}{
        border-radius: $radius_lg;
    }
}
.p-content__main{
    width: 70%;
    overflow: hidden;
    background: $bg-color_content;
    box-shadow: $box-shadow-sm;
    @media #{map-get($breakpoints,'sm')}{
        border-radius: $radius_lg;
    }
}
.p-content__text{
    padding: $space_xl;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: space-between;
}
.p-product__container{
    width: 15rem;
    height: 20rem;
    padding: 1rem;
    background-color: lightgray;
    display: flex;
    position: relative;
    flex-direction: column;
    align-items: center;
    box-sizing: border-box;
    border-radius: $radius_sm;
    &--image{
        width: 13rem;
        height: 13rem;
        object-fit: cover;
        margin: 0 auto;
        border-radius: $radius_sm;
    }
    &--category{
        font-size: $font-size_m;
        padding: 0.2rem;
        position: absolute;
        top: 1.2rem;
        left: 1.2rem;
        background-color: white;
        border-radius: $radius_sm;
    }
    &--maker{
        font-size: $font-size_m;
        width: 100%;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    &--name{
        width: 100%;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    &--size{
        font-size: $font-size_m;
        width: 100%;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    &--status{
        font-size: $font-size_m;
        position: absolute;
        bottom: 1rem;
        color: red;
    }
}
.p-paginate{
    display: flex;
    justify-content: center;
    margin-bottom: $space_md;
}
.p-modal{
    padding: $space_lg;
}
.p-modal__title{
    font-size: $font-size_l;
    line-height: $line-height_sm;
    font-weight: $font-weight_m;
}
.p-modal__text{
    margin-top: $space_xs;
    font-size: $font-size_m;
    line-height: $line-height_sm;
    color: $font-color_light;
    display: flex;
    gap: 0.5rem;
}
.p-modal__button{
    display: flex;
    margin-top: $space_lg;
    justify-content: flex-end;
}
.p-modal__left{
    width: 50%;
    &--image{
        width: 100%;
        height: auto;
    }
}
.p-modal__right{
    width: 50%;
}
.u-title-container{
    display: flex;
    position: relative;
    gap: $space_lg;
    &__button{
        position: absolute;
        top: -0.3rem;
        left: 3.4rem; // ***1
    }
}
.u-button{
    margin-inline-start: $space_xsm;
}
</style>