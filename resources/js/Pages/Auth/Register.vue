<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div class="p-content">
                <InputLabel for="name" value="お名前" />

                <TextInput
                    id="name"
                    type="text"
                    class="p-content__input"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="p-content__error" :message="form.errors.name" />
            </div>

            <div class="p-content">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="p-content__input"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="p-content__error" :message="form.errors.email" />
            </div>

            <div class="p-content">
                <InputLabel for="password" value="パスワード" />

                <TextInput
                    id="password"
                    type="password"
                    class="p-content__input"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="p-content__error" :message="form.errors.password" />
            </div>

            <div class="p-content">
                <InputLabel for="password_confirmation" value="パスワード(再入力)" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="p-content__input"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="p-content__error" :message="form.errors.password_confirmation" />
            </div>

            <div class="p-content__button">
                <Link
                    :href="route('login')"
                    class="p-content__button-link"
                >
                    ご登録済みの方はこちら
                </Link>

                <PrimaryButton class="p-content__button-layout" :class="{ 'is-processing': form.processing }" :disabled="form.processing">
                    登録
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
<style scoped lang="scss">
@import "resources/css/_auth.scss";
</style>