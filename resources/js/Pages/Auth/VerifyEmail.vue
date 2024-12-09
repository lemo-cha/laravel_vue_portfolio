<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <div class="p-content">
            ご登録頂きありがとうございます。メールアドレス確認のリンクを送付しましたので、メールに記載のリンクをクリックしてください。メールが届いていない場合には、再送も可能です
        </div>

        <div class="p-status-text" v-if="verificationLinkSent">
            ユーザ登録時に入力頂いたメールアドレス宛にメールアドレス確認リンクを再送しました
        </div>

        <form @submit.prevent="submit">
            <div class="p-content__button u-button__layout-left">
                <PrimaryButton :class="{ 'is-processing': form.processing }" :disabled="form.processing">
                    メールアドレス確認リンクの再送
                </PrimaryButton>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="p-content__button-link"
                    >ログアウト</Link
                >
            </div>
        </form>
    </GuestLayout>
</template>
<style scoped lang="scss">
@use 'resources/css/_auth.scss';
</style>