<script setup>
import { onMounted, ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    showFlashMessage : { //form.recentlySuccessfulなど *FlashMessageを表示させるページではバインドさせる
        type: Boolean,
        required: false,
        default: false,
    },
});

const showingNavigationDropdown = ref(false);

const page = usePage();

//dashboard.vueへのrouteをroleを判定して設定
const getDashboardRoute = ref('');
const getCurrentRoute = ref('');
onMounted(() => {
    let userRoleName = page.props.userRole[0].toLowerCase().replace(' ','');
    getDashboardRoute.value = route(`${userRoleName}.dashboard`);
    getCurrentRoute.value = route().current(`${userRoleName}.dashboard`);
});
</script>

<template>
    <div>
        <div class="l-page">
            <Transition>
                <div v-if="props.showFlashMessage" class="p-flash-message">
                    {{ $page.props.flash.message }}
                </div>
            </Transition>
            <nav class="l-nav">
                <!-- Primary Navigation Menu -->
                <div class="p-nav">
                    <div class="p-nav__container">
                        <div class="p-nav__container_left">
                            <!-- Logo -->
                            <div class="p-nav__container_left-logo">
                                <Link :href="getDashboardRoute">
                                    <ApplicationLogo class="p-logo"/>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="p-nav__container_left-link">
                                <NavLink :href="getDashboardRoute" :active="getCurrentRoute">
                                    HOME
                                </NavLink>
                                <!-- role:User -->
                                <!-- role:Admin -->
                                <NavLink :href="route('units.index')" :active="route().current('units.index')" v-if="page.props.userRole.includes('Admin')">
                                    units
                                </NavLink>
                                <!-- role:Super Admin -->
                            </div>
                        </div>

                        <div class="p-nav__container_right">
                            <!-- Settings Dropdown -->
                            <div class="p-nav__container_right-dropdown">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="p-dropdown">
                                            <button
                                                type="button"
                                                class="p-dropdown__button"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <font-awesome-icon :icon="['fas','fa-caret-down']" class="p-dropdown__button-icon" />
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> プロフィール </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            ログアウト
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="p-hamburger">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="p-hamburger-menu"
                            >
                                <font-awesome-icon class="p-hamburger-menu__icon" v-if="!showingNavigationDropdown" :icon="['fas','fa-bars']" flip />
                                <font-awesome-icon class="p-hamburger-menu__icon" v-if="showingNavigationDropdown" :icon="['fas','fa-xmark']" flip />
                                
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ 'is-navshow': showingNavigationDropdown, 'is-navhidden': !showingNavigationDropdown }"
                    class="p-responsive-nav"
                >
                    <div class="p-responsive-nav__link">
                        <ResponsiveNavLink :href="getDashboardRoute" :active="getCurrentRoute">
                            HOME
                        </ResponsiveNavLink>
                    </div>
                    <!-- Responsive Settings Options -->
                    <div class="p-responsive-nav__setting-options">
                        <div class="p-setting-options__user-info">
                            <div class="p-setting-options__user-info-name">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="p-setting-options__user-info-email">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="p-setting-options__option">
                            <ResponsiveNavLink :href="route('profile.edit')" class="p-setting-options__option-unit">
                                プロフィール
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button" class="p-setting-options__option-unit">
                                ログアウト
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="l-header" v-if="$slots.header">
                <div class="p-header">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
<style scoped lang="scss">
@use 'resources/css/_variables.scss' as *;
/*----------------
---   Layout   ---
----------------*/
.l-page{
    min-height: 100vh; 
    //background: #F3F4F6; *画像を使用しない場合
    background: 
        linear-gradient(rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.6)), 
        url('/images/watercolor_00853_30722048.jpg') center / cover no-repeat fixed;
}
.l-nav{
    border-bottom-width: 1px; 
    border-color: rgba($border_gray,0.5);
    background: $bg-color_content;
}
.l-header{
    background: $bg-color_content;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1),0 1px 2px rgba(0,0,0,0.06);
}
/*-----------------
---   Project   ---
-----------------*/
.p-flash-message {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(0, 0, 0, 0.7);
    color: $bg-color_content;
    padding: 10px;
    border-radius: 5px;
    z-index: 9999;
}
.p-nav{
    padding: 0 $space_md;
    margin: 0 auto;
    max-width: 80rem;
    @media #{map-get($breakpoints,'sm')}{
        padding: 0 $space_lg;
    }
    @media #{map-get($breakpoints,'lg')}{
        padding: 0 $space_xl;
    }
}
.p-nav__container{
    display: flex;
    justify-content: space-between;
    height: 4rem;
    &_left{
        display: flex;
        &-logo{
            width: 2.375rem;
            height: auto;
            display: flex;
            flex-shrink: 0;
            align-items: center;
        }
        &-link{
            display: none;
            margin-left: $space_xl;
            @media #{map-get($breakpoints,'sm')}{
                display: flex;
                margin-top: -1px;
                margin-bottom: -1px;
            }
        }
    }
    &_right{
        display: none;
        @media #{map-get($breakpoints,'sm')}{
            display: flex;
            align-items: center;
            &-dropdown{
                margin-left: $space_xsm;
                position: relative;
            }
        }
    }
}
.p-logo{
    width: 2.5rem;
    height: auto;
}
.p-dropdown{
    display: inline-flex;
    border-radius: $radius_md;
}
.p-dropdown__button{
    display: inline-flex;
    align-items: center;
    padding: $space_sm $space_xsm;
    border: 1px solid transparent;
    font-size: $font-size_m;
    line-height: $line-height_sm;
    font-weight: $font-weight_m;
    border-radius: $radius_md;
    color: $font-color_light;
    background-color: $bg-color_content;
    transition: all 150ms ease-in-out;

    &:hover {
        color: $font-color_default;
    }

    &:focus {
        outline: none;
    }
    &-icon{
        margin-left: $space_sm;
        margin-right: -0.125rem;
        height: 1rem;
        width: 1rem; 
    }
}
.p-hamburger{
    margin-right: -$space_sm;
    display: flex;
    align-items: center;
    @media #{map-get($breakpoints,'sm')}{
        display: none;
    }
}
.p-hamburger-menu{
    display: inline-flex; 
    padding: $space_sm; 
    justify-content: center; 
    align-items: center; 
    border-radius: $radius_md; 
    color: $font-color_light;
    &:hover{
        color: $font-color_light; 
        background-color: $bg-active_gray; 
    }
    &:focus{
        outline-style: none; 
        color: $font-color_light; 
        background-color: $bg-active_gray; 
    }
}
.p-hamburger-menu__icon{
    width: 1.5rem; 
    height: 1.5rem;
    --fa-animation-iteration-count: 0.5;
}
.p-responsive-nav{
    @media #{map-get($breakpoints,'sm')}{
        display: none;
    }
}
.p-responsive-nav__link{
    padding-top: $space_sm;
    padding-bottom: $space_xsm;
    margin-top: $space_xs;
}
.p-responsive-nav__setting-options{
    padding-bottom: $space_xs;
    padding-top: $space_md;
    border-top-width: 1px;
    border-color: $border_gray;
}
.p-setting-options__user-info{
    padding: 0 $space_md;
    &-name{
        line-height: $line-height_sm;
        font-weight: $font-weight_m;
        color: $font-color_default;
    }
    &-email{
        font-size: $font-size_m;
        line-height: $line-height_sm;
        font-weight: $font-weight_m;
        color: $font-color_light;
    }
}
.p-setting-options__option{
    margin-top: $space_md;
    &-unit{
        margin-top: $space_xs;
    }
}
.p-header{
    margin: auto;
    padding: $space_lg $space_md;
    max-width: 80rem;
    font-size: 1.25rem;
    font-weight: 600;
    line-height: $line-height_sm;
    @media #{map-get($breakpoints,'sm')}{
        padding: $space_lg $space_lg;
    }
    @media #{map-get($breakpoints,'lg')}{
        padding: $space_lg $space_xl;
    }
}
/*-----------------
---   Utility   ---
-----------------*/
.is-navshow{
    display: block;
}
.is-navhidden{
    display: none;
}
.v-enter-active,.v-leave-active{
    transition: opacity 0.5s ease;
}
.v-enter-from, .v-leave-to{
    opacity: 0;
}
</style>