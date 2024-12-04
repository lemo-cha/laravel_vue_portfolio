<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import BackButton from '@/Components/BackButton.vue';

const props = defineProps({
    supplier: {
        type: Object,
    }
})
const form = useForm({});
const showDeleteModal = ref(false);

const editSupplier = () => {
    form.get(route('suppliers.edit',{supplier:props.supplier.id}));
}
const deleteSupplier = () => {
    showDeleteModal.value = true;
}
const destroySupplier = () => {
    form.delete(route('suppliers.destroy',{supplier:props.supplier.id}));
}
const closeModal = () => {
    showDeleteModal.value = false;
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2>顧客情報 詳細</h2>
        </template>

        <div class="l-page">
            <div class="l-page__container">
                <div class="p-content">
                    <div class="p-content__text">
                        <table class="p-content__table">
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">ID</th>
                                <td class="p-content__table--column-data">
                                    {{ supplier.custom_id }}
                                </td>
                            </tr>
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">名前</th>
                                <td class="p-content__table--column-data">
                                    {{ supplier.full_name }}
                                </td>
                            </tr>
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">読み仮名</th>
                                <td class="p-content__table--column-data">
                                    {{ supplier.kana }}
                                </td>
                            </tr>
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">電話番号</th>
                                <td class="p-content__table--column-data">
                                    {{ supplier.tel }}
                                </td>
                            </tr>
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">住所</th>
                                <td class="p-content__table--column-data">
                                    {{ supplier.address}}
                                </td>
                            </tr>
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">請求先住所</th>
                                <td class="p-content__table--column-data">
                                    {{ supplier.billing_address }}
                                </td>
                            </tr>
                        </table>
                        <table class="p-content__table">
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">銀行名</th>
                                <td class="p-content__table--column-data">
                                    {{ supplier.bank_name }}
                                </td>
                            </tr>
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">口座番号</th>
                                <td class="p-content__table--column-data">
                                    {{ supplier.bank_number }}
                                </td>
                            </tr>
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title" >備考</th>
                                <td class="p-content__table--column-data" >
                                    {{ supplier.remarks }}
                                </td>
                            </tr>
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">取引状態</th>
                                <td class="p-content__table--column-data">
                                    {{ supplier.is_active }}
                                </td>
                            </tr>
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">登録日</th>
                                <td class="p-content__table--column-data">
                                    {{ supplier.created_at }}
                                </td>
                            </tr>
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">最終更新日</th>
                                <td class="p-content__table--column-data">
                                    {{ supplier.updated_at }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="p-content__button--container">
                        <BackButton />
                        <PrimaryButton :disabled="form.processing" @click="editSupplier">編集</PrimaryButton>
                        <DangerButton :disabled="form.processing" @click="deleteSupplier">削除</DangerButton>
                    </div>
                    <Modal :show="showDeleteModal">
                        <div class="p-modal">
                            <h2 class="p-modal__title">
                                本当に削除してよろしいですか？
                            </h2>

                            <p class="p-modal__text">
                                売上データと紐づいている顧客情報は削除できません。<br>
                                取引停止の登録のみ、行うことができます。
                            </p>
                            <div class="p-modal__button">
                                <SecondaryButton @click="closeModal"> キャンセル </SecondaryButton>

                                <DangerButton
                                    :class="{ 'is-processing': form.processing }"
                                    :disabled="form.processing"
                                    @click="destroySupplier"
                                >
                                    削除
                                </DangerButton>
                            </div>
                        </div>
                    </Modal>
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
    display: flex;
}
.p-content__table{
    width: 48%;
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
    white-space: normal;
}
.p-content__table--column{
    &:nth-child(odd){
        background: rgba($accent-color,0.6);
    }
    &:nth-child(even){
        background: rgba($accent_color,0.3);
    }
}
.p-content__button--container{
    padding-bottom: $space_lg;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: $space_md;
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
}
.p-modal__button{
    display: flex;
    margin-top: $space_lg;
    justify-content: flex-end;
    gap: $space_md;
}
.is-processing{
    opacity: 0.25;
    pointer-events: none;
}
</style>