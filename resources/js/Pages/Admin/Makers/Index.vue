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
import SelectBox from '@/Components/SelectBox.vue';
import { ref } from 'vue';

const props = defineProps({
    makers:{
        type: Array,
        default: () => [],
    },
    company_types:{
        type: Array,
        default: () => [],
    }
});
console.log(props.makers);
const form = useForm({
    custom_id: '',
    company_type: '',
    name: '',
    brand: '',
});
const editForm = useForm ({
    custom_id: '',
    company_type: '',
    name: '',
    brand: '',
});
const deleteForm = useForm({});

const showEditModal = ref(false);
const showDeleteModal = ref(false);
const showHowToUseModal = ref(false);
const selectId = ref(''); //データのprimaryKeyを取得し、editMakerからupdateMaker,deleteMakerからdestroyMakerに渡す

const storeMaker = () => {
    form.post(route('makers.store'),{
        onSuccess: () => form.reset(),
    });
}
const editMaker = (maker) => {
    showEditModal.value = true;
    editForm.custom_id = maker.custom_id.slice(0,-3);
    editForm.company_type = maker.company_type;
    editForm.name = maker.name;
    editForm.brand = (maker.brand === null) ? '' : maker.brand;
    selectId.value = maker.id;
}
const updateMaker = () => {
    editForm.patch(route('makers.update',{maker:selectId.value}),{
        onSuccess: () => {
            closeModal();
            editForm.reset();
        }
    });
}
const deleteMaker = (id) => {
    showDeleteModal.value = true;
    selectId.value = id;
}
const destroyMaker = () => {
    deleteForm.delete(route('makers.destroy',{maker:selectId.value}),{
        onSuccess: () => closeModal(),
    });
}
const closeModal = () => {
    showEditModal.value = false;
    showDeleteModal.value = false;
    showHowToUseModal.value = false;
}
const showHowToUse = () => {
    showHowToUseModal.value = true;

}
</script>

<template>
    <Head title="makers" />

    <AuthenticatedLayout :showFlashMessage="form.recentlySuccessful || editForm.recentlySuccessful || deleteForm.recentlySuccessful">
        <template #header>
            <div class="u-title-container">
            <h2>メーカー・ブランド</h2>
            <PrimaryButton @click="showHowToUse" class="u-title-container__button">使い方を確認</PrimaryButton>
            </div>
            <Modal :show="showHowToUseModal">
                <div class="p-modal">
                    <h2 class="p-modal__title">
                        使い方
                    </h2>

                        <ol class="p-modal__text u-modal__how-to-use-list">
                            <li>
                                IDは、メーカー名の最初の一文字をアルファベットで入力してください<br>
                                日本語読みで登録するのが望まれます<br>
                                (例)OK[a,ka,shi,など] NG[la,ai,si,tu,など]
                            </li>
                            <li>
                                アルファベット以降3桁の数字は、お好みでつけてください。必ず3桁で入力してください
                            </li>
                            <li>
                                ブランド名は、未入力でも登録することができます<br>
                                メーカーに通称があるとき、ブランド名に入力することでわかりやすくしたり、メーカーが扱っているブランドごとに分けたい場合に使用します<br>
                                ブランドごとに登録する場合、同じIDを指定して、自動入力されたメーカー名をご確認ください<br>
                                内部ではブランドごとにさらにIDを分けますが、自動で付与するので、任意の数字を当てることはできません<br>
                            </li>
                            <li>
                                鋲螺製品について<br>
                                鋲螺製品の場合、次のような登録方法が望ましいです<br>
                                メーカー名：素材名(鉄、ステンレス等)<br>
                                ブランド名：メッキ名(生地、ユニクロメッキ等)<br>
                            </li>
                        </ol>
                    <div class="p-modal__button">
                        <SecondaryButton @click="closeModal"> 閉じる </SecondaryButton>
                    </div>
                </div>
            </Modal>
        </template>

        <div class="l-page">
            <div class="l-page__container">
                <div class="p-content">
                    <div class="p-content__text">
                        <div class="p-content__form">
                            <form @submit.prevent="storeMaker" class="p-content__form">
                                <p class="p-content__form-title">新規登録</p>
                                <!-- <p class="p-content__form-title">{{  }}</p> -->
                                <div class="p-content__form-input">
                                    <InputLabel for="custom_id" value="ID" />

                                    <TextInput
                                        id="custom_id"
                                        type="text"
                                        class="p-content__form-input-field"
                                        v-model="form.custom_id"
                                        required
                                        autofocus
                                    />

                                    <InputError class="p-content__form-input-error" :message="form.errors.custom_id" />
                                </div>
                                <div class="p-content__form-input">
                                    <InputLabel for="company_type" value="会社形態" />
                                    
                                    <SelectBox v-model="form.company_type" :options="company_types" class="p-content__form-input-field"/>

                                    <InputError class="p-content__form-input-error" :message="form.errors.company_type" />
                                </div>
                                <div class="p-content__form-input">
                                    <InputLabel for="name" value="メーカー名" />

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
                                <div class="p-content__form-input">
                                    <InputLabel for="brand" value="ブランド名" />

                                    <TextInput
                                        id="brand"
                                        type="text"
                                        class="p-content__form-input-field"
                                        v-model="form.brand"
                                        autofocus
                                    />

                                    <InputError class="p-content__form-input-error" :message="form.errors.brand" />
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
                                <th class="p-content__table--column-title">メーカー名</th>
                                <th class="p-content__table--column-title">ブランド名</th>
                                <th class="p-content__table--column-title"></th>
                                <th class="p-content__table--column-title"></th>
                            </tr>
                            
                            <tr v-for="(maker,index) in makers" :key="maker.id" class="p-content__table--column">
                                <td class="p-content__table--column-data">{{ index + 1 }}</td>
                                <td class="p-content__table--column-data">{{ maker.custom_id.slice(0,-3) }}</td>
                                <td class="p-content__table--column-data">{{ maker.abbr_name }}</td>
                                <td class="p-content__table--column-data">{{ (maker.brand === null) ? '' : maker.brand }}</td>
                                <td class="p-content__table--column-data">
                                    <PrimaryButton :disabled="form.processing" @click="editMaker(maker)">編集</PrimaryButton>
                                </td>
                                <td class="p-content__table--column-data">
                                    <DangerButton :disabled="form.processing" @click="deleteMaker(maker.id)">削除</DangerButton>
                                </td>
                            </tr>
                        </table>
                        <Modal :show="showEditModal">
                            <div class="p-modal">
                                <h2 class="p-modal__title">
                                    メーカー名を編集
                                </h2>

                                <p class="p-modal__text">
                                    メーカー名を編集すると、登録済みの商品への入力も変更されます<br>
                                    登録済みの売上、仕入情報にも影響します<br>
                                    <span class="u-modal__text--caution">
                                        同じIDで登録があるとき、ID、会社形態、メーカー名を変更すると、すべての登録が変更されます
                                    </span>
                                </p>

                                <form @submit.prevent="updateMaker">
                                    <div class="p-modal__input">
                                        <InputLabel for="custom_id" value="ID" />

                                        <TextInput
                                            id="custom_id"
                                            v-model="editForm.custom_id"
                                            type="text"
                                            class="p-modal__input-field"
                                            autofocus
                                        />

                                        <InputError :message="editForm.errors.custom_id" class="p-modal__input-error" />
                                    </div>
                                    <div class="p-content__form-input">
                                        <InputLabel for="company_type" value="会社形態" />

                                        <SelectBox v-model="editForm.company_type" :options="company_types" class="p-modal__input-field"/>

                                    <InputError class="p-content__form-input-error" :message="editForm.errors.company_type" />
                                    </div>
                                    <div class="p-modal__input">
                                        <InputLabel for="name" value="メーカー名" />

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
                                    <div class="p-modal__input">
                                        <InputLabel for="brand" value="ブランド名" />

                                        <TextInput
                                            id="brand"
                                            type="text"
                                            class="p-modal__input-field"
                                            v-model="editForm.brand"
                                        />

                                        <InputError class="p-modal__input-error" :message="editForm.errors.brand" />
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
                                    商品情報と紐づいているメーカー名は削除できません。<br>
                                    商品情報を編集して、メーカー名を使用していないことを確認してから、削除してください。
                                </p>
                                <div class="p-modal__button">
                                    <SecondaryButton @click="closeModal"> キャンセル </SecondaryButton>

                                    <DangerButton
                                        class="u-button"
                                        :class="{ 'is-processing': form.processing }"
                                        :disabled="form.processing"
                                        @click="destroyMaker"
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
    width: 45%;
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
    width: 55%;
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
.p-flash-message {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(0, 0, 0, 0.7);
    color: $bg-color_content;
    padding: 10px;
    border-radius: 5px;
    z-index: 9999;
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
.u-title-container{
    display: flex;
    position: relative;
    gap: $space_lg;
}
.u-modal__how-to-use-list{
    list-style-type: number;
}
.u-modal__text--caution{
    color: $error_color;
}
</style>