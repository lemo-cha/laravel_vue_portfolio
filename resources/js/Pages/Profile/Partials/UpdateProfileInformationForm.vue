<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section>
        <header>
            <h2 class="p-content__title">アカウント情報</h2>

            <p class="p-content__text">
                アカウント情報とメールアドレスを更新できます
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="p-content__form">
            <div class="p-content__form-input">
                <InputLabel for="name" value="お名前" />

                <TextInput
                    id="name"
                    type="text"
                    class="p-content__form-input-field"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="p-content__form-input-error" :message="form.errors.name" />
            </div>

            <div class="p-content__form-input">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="p-content__form-input-field"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="p-content__form-input-error" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="u-text">
                    メールアドレスが未確認です
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="u-text__link"
                    >
                    ここをクリックすると確認用メールを再送します
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="u-text-success"
                >
                あなたのメールアドレスに確認用のリンクが送信されました
                </div>
            </div>

            <div class="p-content__button">
                <PrimaryButton :disabled="form.processing">保存</PrimaryButton>

                <Transition>
                    <p v-if="form.recentlySuccessful" class="p-content__button-message">保存しました</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
<style scoped lang="scss">
@import "resources/css/_profile.scss";
</style>