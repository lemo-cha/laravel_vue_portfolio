<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { onMounted, ref } from 'vue';

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    userRole: {
        type: Array,
    },
});

const getDashboardRoute = ref('');

onMounted(() => {
    //ログインしている場合、HOMEのLinkをroleごとにわける
    if(props.userRole && props.userRole.length > 0){
        let userRoleName = props.userRole[0].toLowerCase().replace(' ','');
        getDashboardRoute.value = route(`${userRoleName}.dashboard`);
    }
});
</script>

<template>
    <Head title="Welcome" />
    <div class="l-page">
        <div class="l-page__container">
            <div class="l-page__wrapper">
                <header class="p-header">
                    <div class="p-header__logo">
                        <ApplicationLogo class="p-header__logo-img"/>
                    </div>
                    <nav v-if="props.canLogin" class="p-header__nav">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="getDashboardRoute"
                            class="p-header__nav-menu"
                        >
                            HOME
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="p-header__nav-menu"
                            >
                                ログイン
                            </Link>

                            <Link
                                v-if="props.canRegister"
                                :href="route('register')"
                                class="p-header__nav-menu"
                            >
                                登録
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="p-main">
                    
                </main>

                <footer class="p-footer">
                    footer
                </footer>
            </div>
        </div>
    </div>
</template>
<style scoped lang="scss">
@import "resources/css/_variables.scss";
/*----------------
---   Layout   ---
----------------*/
.l-page{
    background: #f9fafb;
    color: $font-color_default;
    font-family: $font-default;
    width: 100%;
    height: 100vh;
    overflow: hidden;
    background: 
        linear-gradient(rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.6)), 
        url(images/watercolor_00853_30722048.jpg) center / cover no-repeat fixed;
}
.l-page__container{
    position: relative;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.l-page__wrapper{
    position: relative;
    padding: 0 $space_lg;
    width: 100%;
    max-width: 42rem;
    @media #{map-get($breakpoints,'lg')}{
        max-width: 80rem;
    }
}
/*------------------
---   Project   ---
------------------*/
.p-header{
    display: grid;
    padding: $space_xxl 0;
    grid-template-columns: repeat(2,minmax(0,1fr));
    gap: $space_sm;
    align-items: center;
    @media #{map-get($breakpoints,'lg')}{
        grid-template-columns: repeat(3,minmax(0,1fr));
    }
}
.p-header__logo{
    display: flex;
    @media #{map-get($breakpoints,'lg')}{
        grid-column-start: 2;
        justify-content: center;
    }
    &-img{
        width: 5rem;
        height: auto;
    }
}
.p-header__nav{
    display: flex;
    margin: auto -$space_xsm;
    flex: 1 1 0%;
    justify-content: flex-end;
    &-menu{
        padding: $space_sm $space_xsm;
        &:hover{
            opacity: 0.7;
        }
    }
}
.p-main{
    margin-top: $space_lg;
}
.p-footer{
    padding: 4rem 0;
    font-size: $font-size_m;
    line-height: $line-height_sm;
    text-align: center;
}
</style>