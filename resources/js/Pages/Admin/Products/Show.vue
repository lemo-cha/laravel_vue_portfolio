<script setup>
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import BackButton from '@/Components/BackButton.vue';

const props = defineProps({
	product:{
		type: Object,
	}
})

const form = useForm({});
const selectedImg = ref('');
const showDeleteModal = ref(false);
const showImageModal = ref(false);

onMounted(() => {
	selectedImg.value = props.product.image_1; // 一番大きいimg表示に1枚目の画像を入れておく
})

const selectImg = (productImg) => { // 小さい画像をクリックすると大きいimg欄が切り替わる
	selectedImg.value = productImg;
}
const viewProductImage = () => {
	showImageModal.value = true;
}
const editProduct = () => {
	form.get(route('products.edit',{product:props.product.id}));
}
const deleteProduct = () => {
	showDeleteModal.value = true;
}
const destroyProduct = () => {
	form.delete(route('products.destroy',{product:props.product.id}));
}
const closeModal = () => {
	showDeleteModal.value = false;
	showImageModal.value = false;
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2>商品詳細</h2>
        </template>

        <div class="l-page">
            <div class="l-page__container">
                <div class="p-content">
                    <div class="p-content__text"> <!-- 本来はp-containerであるべき -->
						<div class="p-container__left">
							<div class="p-container__left--image-main">
								<img :src="selectedImg" alt="" class="p-image__main" @click="viewProductImage">
							</div>
							<Modal :show="showImageModal">
								<img :src="selectedImg" alt="" class="p-modal__image">
								<div class="p-modal__button">
									<SecondaryButton @click="closeModal">閉じる</SecondaryButton>
								</div>
							</Modal>
							<div class="p-container__left--image-sub">
								<img v-for="(img,index) in [product.image_1,product.image_2,product.image_3]" :key="index"
								:src="img" alt="" class="p-image__sub" :class="{ 'is_selected': selectedImg === img }"
								@click="selectImg(img)">
							</div>
						</div>
						<div class="p-container__right">
							<table class="p-content__table">
								<tr class="p-content__table--column">
									<th class="p-content__table--column-title">ID</th>
									<td class="p-content__table--column-data">{{ product.custom_id }}</td>
								</tr>
								<tr class="p-content__table--column">
									<th class="p-content__table--column-title">カテゴリー</th>
									<td class="p-content__table--column-data">{{ product.category }}</td>
								</tr>
								<tr class="p-content__table--column">
									<th class="p-content__table--column-title">メーカー・ブランド</th>
									<td class="p-content__table--column-data">{{ product.maker }}</td>
								</tr>
								<tr class="p-content__table--column">
									<th class="p-content__table--column-title">商品名</th>
									<td class="p-content__table--column-data">{{ product.name }}</td>
								</tr>
								<tr class="p-content__table--column">
									<th class="p-content__table--column-title">サイズ</th>
									<td class="p-content__table--column-data">{{ product.size }}</td>
								</tr>
								<tr class="p-content__table--column">
									<th class="p-content__table--column-title">品番</th>
									<td class="p-content__table--column-data">{{ product.product_number }}</td>
								</tr>
								<tr class="p-content__table--column">
									<th class="p-content__table--column-title">説明</th>
									<td class="p-content__table--column-data">{{ product.description }}</td>
								</tr>
								<tr class="p-content__table--column">
									<th class="p-content__table--column-title">商品ステータス</th>
									<td class="p-content__table--column-data">{{ product.status }}</td>
								</tr>
								<tr class="p-content__table--column">
									<th class="p-content__table--column-title"></th> <!--商品ステータスの詳細-->
									<td class="p-content__table--column-data">{{ product.status_description }}</td>
								</tr>
								<tr class="p-content__table--column">
									<th class="p-content__table--column-title">備考</th>
									<td class="p-content__table--column-data">{{ product.remarks }}</td>
								</tr>
                            </table>
							<div class="p-button__container">
								<BackButton />
								<PrimaryButton :disabled="form.processing" @click="editProduct">
									編集
								</PrimaryButton>
								<DangerButton :disabled="form.processing" @click="deleteProduct">
									削除
								</DangerButton>
							</div>
							<Modal :show="showDeleteModal">
								<div class="p-modal">
									<h2 class="p-modal__title">
										本当に削除してよろしいですか？
									</h2>

									<p class="p-modal__text">
										売上データと紐づいている商品情報は削除できません。<br>
										商品ステータスの編集をして、削除以外の処理を検討してください。
									</p>
									<div class="p-modal__button">
										<SecondaryButton @click="closeModal"> キャンセル </SecondaryButton>

										<DangerButton
											:class="{ 'is-processing': form.processing }"
											:disabled="form.processing"
											@click="destroyProduct"
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
.p-container__left{
	width: 50%;
	&--image-main{
		width: 100%;
		display: flex;
	}
	&--image-sub{
		width: 100%;
		margin-top: 0.5rem;
		display: flex;
		justify-content: center;
		gap: 1rem;
	}
}
.p-image__main{
	width: 20rem;
	height: 20rem;
	object-fit: cover;
	margin: 0 auto;
	text-align: center;
}
.p-image__sub{
	width: 10rem;
	height: 10rem;
	object-fit: cover;
	border: 3px solid rgba($accent-color,0); //初期値は透明、currentのときactiveになる
	border-radius: $radius_md;
	padding: 4px;
}
.p-container__right{
	width: 50%;
	position: relative;
}
.p-content__table{
    width: 90%;
    margin-left: auto;
    margin-right: auto;
    border-collapse: collapse;
    border-spacing: 0;
    padding: $space_lg;
}
.p-content__table--column-title{
    background-color: $accent-color;
    color: $bg-color_content;
	white-space: nowrap;
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
.p-button__container{
	width: 100%;
	margin-top: 4rem;
	display: flex;
	justify-content: center;
	gap: 1rem;
	position: absolute;
	bottom: 2rem;
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
.p-modal__image{
	width: 100%;
	height: auto;
}
.is_selected{
	border-color: rgba($accent-color,0.6);
}
.is-processing{
    opacity: 0.25;
    pointer-events: none;
}
</style>