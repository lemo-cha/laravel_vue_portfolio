<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="p-content">
            パスワードをお忘れの場合は、ご登録時のメールアドレスを入力頂ければ、パスワードリセットのためのリンクをメールで送信いたします
        </div>

        <div v-if="status" class="p-status-text">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
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

            <div class="p-content__button">
                <PrimaryButton :class="{ 'is-processing': form.processing }" :disabled="form.processing">
                    パスワードリセットメールを送信
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
<style scoped lang="scss">
@import "resources/css/_auth.scss";
</style>