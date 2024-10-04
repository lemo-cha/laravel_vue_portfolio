<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password" />

        <div class="p-content">
            認証が必要なページです<br>
            パスワードを入力して確認ボタンをクリックしてください
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="p-content__input"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                />
                <InputError class="p-content__error" :message="form.errors.password" />
            </div>

            <div class="p-content__button">
                <PrimaryButton class="p-content__button-layout" :class="{ 'is-processing': form.processing }" :disabled="form.processing">
                    確認
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
<style scoped lang="scss">
@import "resources/css/_auth.scss";
</style>