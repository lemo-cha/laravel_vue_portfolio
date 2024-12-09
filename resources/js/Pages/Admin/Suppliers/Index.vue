<script setup>
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,router } from '@inertiajs/vue3';

const props = defineProps({
    suppliers : ({
        type: Object,
        default: [],
    })
})

const createSupplier = () => {
    router.get(route('suppliers.create'));
}
const showSupplier = (id) => {
    router.get(route('suppliers.show',{supplier: id}));
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2>仕入先情報</h2>
        </template>

        <div class="l-page">
            <div class="l-page__container">
                <div class="p-content">
                    <div class="p-content__text">検索</div>       <!-- *** 検索ボックスを作りたい！ -->
                    <div class="p-content__text">
                        新規登録
                        <PrimaryButton @click="createSupplier">新規登録</PrimaryButton>
                    </div>
                </div>
            </div>
            <div class="l-page__container">
                <div class="p-content">
                    <div class="p-content__text">
                        <table class="p-content__table">
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">No.</th>
                                <th class="p-content__table--column-title">ID</th>
                                <th class="p-content__table--column-title">名前</th>
                                <th class="p-content__table--column-title">取引状態</th>
                            </tr>
                                
                            <tr v-for="(supplier,index) in suppliers.data" :key="supplier.id" class="p-content__table--column"
                                @click="showSupplier(supplier.id)">
                                    <td class="p-content__table--column-data">{{ index + 1 }}</td>
                                    <td class="p-content__table--column-data">{{ supplier.custom_id }}</td>
                                    <td class="p-content__table--column-data">{{ supplier.name }}</td>
                                    <td class="p-content__table--column-data">{{ supplier.is_active }}</td>
                            </tr>
                        </table>
                        <Pagination :links="suppliers.links" class="p-paginate" />
                    </div>
                </div>
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
    background: $bg-color_content;
    box-shadow: $box-shadow-sm;
    @media #{map-get($breakpoints,'sm')}{
        border-radius: $radius_lg;
    }
}
.p-content__text{
    padding: $space_lg;
}
.p-content__table{
    width: 55%;
    margin-left: auto;
    margin-right: auto;
    border-collapse: collapse;
    border-spacing: 0;
    padding: $space_lg;
}
.p-content__table--column-title{
    background-color: $accent-color;
    color: $bg-color_content;
}
.p-content__table--column-title,
.p-content__table--column-data{
    padding: $space_sm 0;
    vertical-align: middle;
    text-align: center;
}
.p-content__table--column{
    &:nth-child(odd){
        background: rgba($accent-color,0.6);
    }
    &:nth-child(even){
        background: rgba($accent_color,0.3);
    }
}
.p-paginate{
    display: flex;
    justify-content: center;
    margin-top: $space_md;
}
</style>