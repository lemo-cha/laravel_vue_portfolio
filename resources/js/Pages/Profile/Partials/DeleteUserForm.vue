<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section>
        <header>
            <h2 class="p-content__title">アカウントを削除</h2>

            <p class="p-content__text">
                アカウントを削除すると、全てのデータとファイルも完全に削除されます。アカウントを削除する前に必要なデータがあれば事前にダウンロードの実施をお願いします。
            </p>
        </header>

        <DangerButton class="p-content__button" @click="confirmUserDeletion">削除</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-modal">
                <h2 class="p-modal__title">
                    アカウントを削除して本当に大丈夫ですか？
                </h2>

                <p class="p-modal__text">
                    アカウントを削除すると、全てのデータとファイルも完全に削除されます。完全にアカウントを削除するためには、確認のために再度パスワードを入力してください。
                </p>

                <div class="p-modal__input">
                    <InputLabel for="password" value="パスワード" class="p-modal__input-label" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="p-modal__input-field"
                        placeholder="Password"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="p-modal__input-error" />
                </div>

                <div class="p-modal__button">
                    <SecondaryButton @click="closeModal"> キャンセル </SecondaryButton>

                    <DangerButton
                        class="u-button"
                        :class="{ 'is-processing': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        削除
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
<style scoped lang="scss">
@use 'resources/css/_profile.scss';
</style>