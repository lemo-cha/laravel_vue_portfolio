<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import { padNumber } from '@/utils';

const props = defineProps({
    categories:{
        type: Array,
        default: () => [],
    },
});
const form = useForm({
    custom_id: '',
    name: '',
});
const editForm = useForm ({
    custom_id: '',
    name: '',
});
const deleteForm = useForm({});

const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectId = ref(''); //データのprimaryKeyを取得し、editCategoryからupdateCategory,deleteCategoryからdestroyCategoryに渡す

const storeCategory = () => {
    form.post(route('categories.store'),{
        onSuccess: () => form.reset(),
    });
}
const editCategory = (category) => {
    showEditModal.value = true;
    editForm.custom_id = category.custom_id;
    editForm.name = category.name;
    selectId.value = category.id;
}
const updateCategory = () => {
    editForm.patch(route('categories.update',{category:selectId.value}),{
        onSuccess: () => {
            closeModal();
            editForm.reset();
        }
    });
}
const deleteCategory = (id) => {
    showDeleteModal.value = true;
    selectId.value = id;
}
const destroyCategory = () => {
    deleteForm.delete(route('categories.destroy',{category:selectId.value}),{
        onSuccess: () => closeModal(),
    });
}
const closeModal = () => {
    showEditModal.value = false;
    showDeleteModal.value = false;
}
</script>

<template>
    <Head title="categories" />

    <!-- <AuthenticatedLayout :showFlashMessage="form.recentlySuccessful || editForm.recentlySuccessful || deleteForm.recentlySuccessful"> -->
    <AuthenticatedLayout>
        <template #header>
            <h2>商品カテゴリー</h2>
        </template>

        <div class="l-page">
            <div class="l-page__container">
                <div class="p-content">
                    <div class="p-content__text">
                        <div class="p-content__form">
                            <form @submit.prevent="storeCategory" class="p-content__form">
                                <p class="p-content__form-title">新規登録</p>
                                <!-- <p class="p-content__form-title">{{  }}</p> -->
                                <div class="p-content__form-input">
                                    <InputLabel for="custom_id" value="ID" />

                                    <TextInput
                                        id="custom_id"
                                        type="number"
                                        class="p-content__form-input-field"
                                        v-model="form.custom_id"
                                        required
                                        autofocus
                                    />

                                    <InputError class="p-content__form-input-error" :message="form.errors.custom_id" />
                                </div>
                                <div class="p-content__form-input">
                                    <InputLabel for="name" value="カテゴリー名" />

                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="p-content__form-input-field"
                                        v-model="form.name"
                                        required
                                        autofocus
                                    />

                                    <InputError class="p-content__form-input-error" :message="form.errors.name" />
                                </div>
                                <div class="p-content__button">
                                    <PrimaryButton type="submit" :disabled="form.processing">登録</PrimaryButton>
                                </div>
                            </form>
                        </div>
                        <table class="p-content__table">
                            <tr class="p-content__table--column">
                                <th class="p-content__table--column-title">No.</th>
                                <th class="p-content__table--column-title">ID</th>
                                <th class="p-content__table--column-title">カテゴリー名</th>
                                <th class="p-content__table--column-title"></th>
                                <th class="p-content__table--column-title"></th>
                            </tr>
                            
                            <tr v-for="(category,index) in categories" :key="category.id" class="p-content__table--column">
                                <td class="p-content__table--column-data">{{ index + 1 }}</td>
                                <td class="p-content__table--column-data">{{ padNumber(category.custom_id,3) }}</td>
                                <td class="p-content__table--column-data">{{ category.name }}</td>
                                <td class="p-content__table--column-data">
                                    <PrimaryButton :disabled="form.processing" @click="editCategory(category)">編集</PrimaryButton>
                                </td>
                                <td class="p-content__table--column-data">
                                    <DangerButton :disabled="form.processing" @click="deleteCategory(category.id)">削除</DangerButton>
                                </td>
                            </tr>
                        </table>
                        <Modal :show="showEditModal">
                            <div class="p-modal">
                                <h2 class="p-modal__title">
                                    カテゴリー名を編集
                                </h2>

                                <p class="p-modal__text">
                                    カテゴリー名を編集すると、登録済みの商品への単位も変更されます。<br>
                                    登録済みの売上、仕入情報にも影響します。
                                </p>
                                <form @submit.prevent="updateCategory">
                                    <div class="p-modal__input">
                                        <InputLabel for="custom_id" value="ID" />

                                        <TextInput
                                            id="custom_id"
                                            v-model="editForm.custom_id"
                                            type="number"
                                            class="p-modal__input-field"
                                            autofocus
                                        />

                                        <InputError :message="editForm.errors.custom_id" class="p-modal__input-error" />
                                    </div>
                                    <div class="p-modal__input">
                                        <InputLabel for="name" value="単位名" />

                                        <TextInput
                                            id="name"
                                            type="text"
                                            class="p-modal__input-field"
                                            v-model="editForm.name"
                                            required
                                            autofocus
                                        />

                                        <InputError class="p-modal__input-error" :message="editForm.errors.name" />
                                    </div>

                                    <div class="p-modal__button">
                                        <SecondaryButton @click="closeModal"> キャンセル </SecondaryButton>

                                        <PrimaryButton
                                            class="u-button"
                                            :class="{ 'is-processing': form.processing }"
                                            :disabled="form.processing"
                                        >
                                            編集
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </Modal>
                        <Modal :show="showDeleteModal">
                            <div class="p-modal">
                                <h2 class="p-modal__title">
                                    本当に削除してよろしいですか？
                                </h2>

                                <p class="p-modal__text">
                                    商品情報と紐づいているカテゴリー名は削除できません。<br>
                                    商品情報を編集して、カテゴリー名を使用していないことを確認してから、削除してください。
                                </p>
                                <div class="p-modal__button">
                                    <SecondaryButton @click="closeModal"> キャンセル </SecondaryButton>

                                    <DangerButton
                                        class="u-button"
                                        :class="{ 'is-processing': form.processing }"
                                        :disabled="form.processing"
                                        @click="destroyCategory"
                                    >
                                        削除
                                    </DangerButton>
                                </div>
                            </div>
                        </Modal>
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
    width: 100%;
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
.p-content__form{
    width: 50%;
    margin: $space_sm auto;
    &-title{
        text-align: center;
        font-size: $font-size_l;
    }
    &-input{
        margin-top: $space_lg;
        &-field{
            display: block;
            margin-top: $space_xs;
            width:  100%;
        }
        &-error{
            margin-top: $space_sm;
        }
    }
}
.p-content__button{
    margin-top: $space_lg;
    display: flex;
    justify-content: flex-end;
    gap: $space_md;
    align-items: center;
}
.p-content__table{
    width: 50%;
    border-collapse: collapse;
    border-spacing: 0;
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
.p-modal__input{
    margin-top: $space_lg;
    &-label{
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
    }
    &-field{
        display: block;
        margin-top: $space_xs;
        width: 75%;
    }
    &-error{
        margin-top: $space_sm;
    }
}
.p-modal__button{
    display: flex;
    margin-top: $space_lg;
    justify-content: flex-end;
}
/*-----------------
---   Utility   ---
-----------------*/
.v-enter-active,.v-leave-active{
    transition: opacity 0.5s ease;
}
.v-enter-from, .v-leave-to{
    opacity: 0;
}
.u-button{
    margin-inline-start: $space_xsm;
}
.is-processing{
    opacity: 0.25;
    pointer-events: none;
}
</style>