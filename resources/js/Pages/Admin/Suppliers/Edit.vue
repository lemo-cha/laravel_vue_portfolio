<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectEnum from '@/Components/SelectEnum.vue';
import SelectHelper from '@/Components/SelectHelper.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';

const props = defineProps({
    supplier: {
        type: Object,
    },
    company_types: {
        type: Array,
    },
	is_actives: {
		type: Array,
	}
})

const form = useForm({
	custom_id: props.supplier.custom_id,
    company_type: props.supplier.company_type,
    name: props.supplier.name,
    kana: props.supplier.kana,
    tel: props.supplier.tel,
    zip: props.supplier.zip,
    address: props.supplier.address,
    billing_zip: props.supplier.billing_zip,
    billing_address: props.supplier.billing_address,
    bank_name: props.supplier.bank_name,
    bank_number: props.supplier.bank_number,
    remarks: props.supplier.remarks,
    is_active: props.supplier.is_active,
});

const updateSupplier = () => {
    form.patch(route('suppliers.update',{supplier:props.supplier.id}),{
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Dashboard" />

    <!-- <AuthenticatedLayout :showFlashMessage="form.recentlySuccessful"> -->
	<AuthenticatedLayout>
        <template #header>
            <h2>顧客情報 編集</h2>
        </template>

        <div class="l-page">
            <div class="l-page__container">
                <div class="p-content">
                    <div class="p-content__text">
						<div class="p-content__form">
                            <form @submit.prevent="updateSupplier" class="p-content__form">
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
											<InputLabel for="company_type" value="会社形態" />
											
											<SelectEnum
												v-model="form.company_type"
												:options="company_types"
												class="p-content__form-input-field"/>

											<InputError class="p-content__form-input-error" :message="form.errors.company_type" />
										</div>
										<div class="p-content__form-input">
											<InputLabel for="name" value="会社名" />

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
											<InputLabel for="kana" value="読み仮名" caution="ひらがなのみ"/>

											<TextInput
												id="brand"
												type="text"
												class="p-content__form-input-field"
												v-model="form.kana"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.kana" />
											
										</div>

									</div>
									<div class="p-content__form-wrap">
										<div class="p-content__form-input">
											<InputLabel for="tel" value="電話番号" caution="数字のみ"/>

											<TextInput
												id="tel"
												type="text"
												class="p-content__form-input-field"
												v-model="form.tel"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.tel" />
											
										</div>
										<div class="p-content__form-input">
											<InputLabel for="zip" value="郵便番号" caution="数字のみ"/>

											<TextInput
												id="zip"
												type="text"
												class="p-content__form-input-field"
												v-model="form.zip"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.zip" />
										</div>
										<div class="p-content__form-input">
											<InputLabel for="address" value="住所" />

											<TextInput
												id="address"
												type="text"
												class="p-content__form-input-field"
												v-model="form.address"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.address" />
										</div>
										<div class="p-content__form-input">
											<InputLabel for="billing_zip" value="請求先郵便番号" />

											<TextInput
												id="billing_zip"
												type="text"
												class="p-content__form-input-field"
												v-model="form.billing_zip"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.billing_zip" />
										</div>
									</div>
									<div class="p-content__form-wrap">
										<div class="p-content__form-input">
											<InputLabel for="billing_address" value="請求先住所" />

											<TextInput
												id="billing_address"
												type="text"
												class="p-content__form-input-field"
												v-model="form.billing_address"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.billing_address" />
											
										</div>
										<div class="p-content__form-input">
											<InputLabel for="bank_name" value="銀行名" />

											<TextInput
												id="bank_name"
												type="text"
												class="p-content__form-input-field"
												v-model="form.bank_name"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.bank_name" />
										</div>
										<div class="p-content__form-input">
											<InputLabel for="bank_number" value="銀行番号" />

											<TextInput
												id="bank_number"
												type="text"
												class="p-content__form-input-field"
												v-model="form.bank_number"
												autofocus
											/>

											<InputError class="p-content__form-input-error" :message="form.errors.bank_number" />
										</div>
									</div>
									<div class="p-content__form-wrap">
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
											<InputLabel for="is_active" value="取引状態" />
											
											<SelectHelper v-model="form.is_active" :options="is_actives" class="p-content__form-input-field"/>

											<InputError class="p-content__form-input-error" :message="form.errors.is_active" />
										</div>
									</div>
								</div>
								<p class="p-content__text--caution">
									請求先住所が住所と同じ場合は、請求先郵便番号と請求先住所は未入力にしてください<br>
									取引状態を無効にする場合、備考に理由を入力するとわかりやすいです。他の情報を入力することもできます。
								</p>
                                <div class="p-content__button">
                                    <PrimaryButton type="submit" :disabled="form.processing">編集</PrimaryButton>
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
.p-content__button{
	margin-right: $space_3l;
    display: flex;
    justify-content: flex-end;
    gap: $space_md;
}
</style>