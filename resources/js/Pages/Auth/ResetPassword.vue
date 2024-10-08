<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <form @submit.prevent="submit">
            <div class="p-content">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="p-content__input"
                    v-model="form.email"
                    required
                    autofocus
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
                <PrimaryButton :class="{ 'is-processing': form.processing }" :disabled="form.processing">
                    リセット
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
<style scoped lang="scss">
@use 'resources/css/_auth.scss';
</style>