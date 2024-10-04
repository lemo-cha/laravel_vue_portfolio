<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="l-page">
            <nav class="l-nav">
                <!-- Primary Navigation Menu -->
                <div class="p-nav">
                    <div class="p-nav__container">
                        <div class="p-nav__container_left">
                            <!-- Logo -->
                            <div class="p-nav__container_left-logo">
                                <Link :href="route('admin.dashboard')">
                                    <ApplicationLogo />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="p-nav__container_left-link">
                                <NavLink :href="route('admin.dashboard')" :active="route().current('admin.dashboard')">
                                    HOME
                                </NavLink>
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
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="p-responsive-nav"
                >
                    <div class="p-responsive-nav__link">
                        <ResponsiveNavLink :href="route('admin.dashboard')" :active="route().current('admin.dashboard')">
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
@import "resources/css/_variables.scss";
/*----------------
---   Layout   ---
----------------*/
.l-page{
    min-height: 100vh; 
    //background: #F3F4F6; *画像を使用しない場合
    font-family: $font-default;
    background: 
        linear-gradient(rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.6)), 
        url(images/watercolor_00853_30722048.jpg) center / cover no-repeat fixed;
}
.l-nav{
    border-bottom-width: 1px; 
    border-color: #F3F4F6;
    background: #ffffff;
}
.l-header{
    background: #ffffff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1),0 1px 2px rgba(0,0,0,0.06);
}
/*-----------------
---   Project   ---
-----------------*/
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
.p-dropdown{
    display: inline-flex;
    border-radius: $radius_md;
}
.p-dropdown__button{
    display: inline-flex;
    align-items: center;
    padding: $space_sm $space_xsm; // px-3 py-2 に相当
    border: 1px solid transparent;
    font-size: $font-size_m;
    line-height: $line-height_sm;
    font-weight: $font-weight_m;
    border-radius: $radius_md; // rounded-md
    color: #6B7280; // text-gray-500
    background-color: #FFFFFF; // bg-white
    transition: all 150ms ease-in-out;

    &:hover {
        color: #374151; // hover:text-gray-700
    }

    &:focus {
        outline: none; // focus:outline-none
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
    color: #9CA3AF; 
    &:hover{
        color: #6B7280; 
        background-color: #F3F4F6; 
    }
    &:focus{
        outline-style: none; 
        color: #6B7280; 
        background-color: #F3F4F6; 
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
    border-color: #e5e7eb;
}
.p-setting-options__user-info{
    padding: 0 $space_md;
    &-name{
        line-height: $line-height_sm;
        font-weight: $font-weight_m;
        color: #1f2937;
    }
    &-email{
        font-size: $font-size_m;
        line-height: $line-height_sm;
        font-weight: $font-weight_m;
        color: #6b7280;
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
        padding-left: $space_lg;
        padding-right: $space_lg;
    }
    @media #{map-get($breakpoints,'lg')}{
        padding-left: $space_xl;
        padding-right: $space_xl;
    }
}
</style>