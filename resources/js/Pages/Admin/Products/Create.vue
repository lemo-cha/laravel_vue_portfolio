<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectEnum from '@/Components/SelectEnum.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import ImageInput from '@/Components/ImageInput.vue';
import SearchCategoryInput from '@/Components/SearchCategoryInput.vue';
import SearchMakerInput from '@/Components/SearchMakerInput.vue';
import SearchUnitInput from '@/Components/SearchUnitInput.vue';
import BackButton from '@/Components/BackButton.vue';

const props = defineProps({
	status_list: {
		type: Array,
	},
})

const form = useForm({
	custom_id: '',
    category_id: '',
    maker_id: '',
    unit_id: '',
    name: '',
    size: '',
    product_number: '',
    description: '',
    image_1: '',
    image_2: '',
    image_3: '',
    remarks: '',
    status: 1,
});

const handleImageUpdate = (file,column) => {
	form[column] = file;
}

const storeProduct = () => {
	form.post(route('products.store'),{
		onSuccess: () => form.reset(),
		onError: (errors) => {
			console.error('エラー：',errors);
		},
    });
}
</script>

<template>
    <Head title="Dashboard" />

    <!-- <AuthenticatedLayout :showFlashMessage="form.recentlySuccessful"> -->
	<AuthenticatedLayout>
        <template #header>
            <h2>商品情報 新規作成</h2>
        </template>

        <div class="l-page">
            <div class="l-page__container">
                <div class="p-content">
                    <div class="p-content__text">
						<div class="p-content__form">
                            <form @submit.prevent="storeProduct" class="p-content__form" enctype="multipart/form-data">
                                <!-- <p class="p-content__form-title">{{  }}</p> -->
								<div class="p-content__form-container">
									<div class="p-content__form-wrap">
										<div class="p-content__form-input">
											<InputLabel for="custom_id" value="ID" />

											<TextInput
												id="custom_id"
												type="text"
												class="p-content__form-input-field"
												v-model="form.custom_id"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.custom_id" />
										</div>
										<div class="p-content__form-input">
											<InputLabel for="category_id" value="カテゴリー" />

											<SearchCategoryInput
												inputId="category_id"
												type="text"
												class="p-content__form-input-field"
												v-model="form.category_id"
                                                :useOnFocusout="true"
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.category_id" />
										</div>
										<div class="p-content__form-input">
											<InputLabel for="maker_id" value="メーカー・ブランド" />

											<SearchMakerInput
												inputId="maker_id"
												type="text"
												class="p-content__form-input-field"
												v-model="form.maker_id"
                                                :useOnFocusout="true"
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.maker_id" />
										</div>
										<div class="p-content__form-input">
											<InputLabel for="unit_id" value="商品単位" />

											<SearchUnitInput
												inputId="unit_id"
												type="text"
												class="p-content__form-input-field"
												v-model="form.unit_id"
                                                :useOnFocusout="true"F
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.unit_id" />
										</div>
									</div>
									<div class="p-content__form-wrap">
										<div class="p-content__form-input">
											<InputLabel for="name" value="商品名" />

											<TextInput
												id="name"
												type="text"
												class="p-content__form-input-field"
												v-model="form.name"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.name" />
										</div>
										<div class="p-content__form-input">
											<InputLabel for="size" value="サイズ" />

											<TextInput
												id="size"
												type="text"
												class="p-content__form-input-field"
												v-model="form.size"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.size" />
										</div>
										<div class="p-content__form-input">
											<InputLabel for="product_number" value="品番" />

											<TextInput
												id="product_number"
												type="text"
												class="p-content__form-input-field"
												v-model="form.product_number"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.product_number" />
										</div>
										<div class="p-content__form-input">
											<InputLabel for="description" value="商品の説明" />

											<TextAreaInput
												id="description"
												type="text"
												class="p-content__form-input-field"
												v-model="form.description"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.description" />
										</div>
									</div>
									<div class="p-content__form-wrap">
										<div class="p-content__form-input">
											<InputLabel for="status" value="商品ステータス" />
											
											<SelectEnum
												inputId="status"
												v-model="form.status"
												:options="status_list"
												class="p-content__form-input-field" />

											<InputError class="p-content__form-input-error" :message="form.errors.company_type" />
										</div>
										<div class="p-content__form-input">
											<InputLabel for="remarks" value="備考" />

											<TextAreaInput
												id="remarks"
												type="text"
												class="p-content__form-input-field"
												v-model="form.remarks"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.remarks" />
										</div>
										<div class="p-content__form-input">
											<ImageInput
												inputId="image_1"
												label="メイン画像"
												caution="必須"
												@image-uploaded="(file) => handleImageUpdate(file,'image_1')"
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.image_1" />

										</div>
									</div>
									<div class="p-content__form-wrap">
										<div class="p-content__form-input">
											<ImageInput
												inputId="image_2"
												label="サブ画像1"
												@image-uploaded="(file) => handleImageUpdate(file,'image_2')"
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.image_2" />

										</div>
										<div class="p-content__form-input">
											<ImageInput
												inputId="image_3"
												label="サブ画像2"
												@image-uploaded="(file) => handleImageUpdate(file,'image_3')"
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.image_3" />

										</div>
									</div>
								</div>
                                <div class="p-content__button">
									<BackButton />
                                    <PrimaryButton type="submit" :disabled="form.processing">登録</PrimaryButton>
                                </div>
                            </form>
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
	&--caution{
		padding-top: $space_lg;
		color: $font-color_light;
	}
}
.p-content__form{
    margin: $space_sm auto;
	margin-top: 0;
	&-container{
		display: flex;
		justify-content: center;
		gap: $space_3l;

	}
	&-wrap{
		width: auto;
	}
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
.p-content__form-v-model{
	margin: 0.2rem;
	min-height: 1rem;
}
.p-content__button{
	margin-right: $space_3l;
    display: flex;
    justify-content: flex-end;
    gap: $space_md;
}
</style>