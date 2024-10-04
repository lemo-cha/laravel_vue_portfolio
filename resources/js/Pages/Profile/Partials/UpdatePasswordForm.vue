<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="p-content__title">パスワード変更</h2>

            <p class="p-content__text">
                十分に長くランダムなパスワードを使用して、アカウントのセキュリティを高めましょう
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="p-content__form">
            <div class="p-content__form-input">
                <InputLabel for="current_password" value="現在のパスワード" />

                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="p-content__form-input-field"
                    autocomplete="current-password"
                />

                <InputError :message="form.errors.current_password" class="p-content__form-input-error" />
            </div>

            <div class="p-content__form-input">
                <InputLabel for="password" value="新しいパスワード" />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="p-content__form-input-field"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password" class="p-content__form-input-error" />
            </div>

            <div class="p-content__form-input">
                <InputLabel for="password_confirmation" value="新しいパスワード(再入力)" />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="p-content__form-input-field"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password_confirmation" class="p-content__form-input-error" />
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