<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="p-status-text">
            {{ status }}
        </div>

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
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="p-content__input"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="p-content__error" :message="form.errors.password" />
            </div>

            <div class="p-content__checkbox">
                <label class="p-content__checkbox-label">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="p-content__checkbox-text">ログイン状態を保持</span>
                </label>
            </div>

            <div class="p-content__button">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="p-content__button-link"
                >
                    パスワードを忘れた方はこちら
                </Link>

                <PrimaryButton class="p-content__button-layout" :class="{ 'is-processing': form.processing }" :disabled="form.processing">
                    ログイン
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
<style scoped lang="scss">
@use 'resources/css/_auth.scss';
</style>