<script setup>
    import PopUp from './PopUp.vue'
    import { route } from 'ziggy-js'
    import logo from '@img/logo.png'
    import { usePage } from '@inertiajs/vue3'
    import { useTopicStore } from '../../Stores/Topic.js'

    //Variables
    let page = usePage()
    let menu = [
        {
            name: 'Home',
            href: route('posts.index', {}, false)
        },
        {
            name: 'Dashboard',
            href: route('dashboard.show', {}, false),
            when: () => page.props.auth !== null
        }
    ].map(item => ({
        ...item,
        isActive: computed(() => page.url.includes(item.href))
    }))

    //Functions
    let resetTopic = () => setTimeout(() => useTopicStore().reset_to_default())
</script>

<template>
    <header class='flex justify-between items-center px-8 py-2 m-5 h-20 text-white bg-gray-800 rounded-lg shadow-md'>
        <Link
            prefetch
            @click="resetTopic"
            :href='route("posts.index")'
        >
            <img
                alt='Logo'
                :src='logo'
                class='w-14 h-14'
            >
        </Link>

        <!-- NavBar -->
        <nav class="flex gap-x-5 mr-auto ml-10">
            <template
                :key='link.name'
                v-for='link in menu'
            >
                <Link
                    prefetch="hover"
                    :href="link.href"
                    v-text="link.name"
                    @click="resetTopic"
                    :class="[ 'transition duration-300 cursor-pointer', {
                        'text-gray-100 hover:text-gray-300': !link.isActive.value,
                        'font-bold !text-purple-400 hover:text-purple-300': link.isActive.value
                    }]"
                    v-if='link.when ? link.when() : true'
                />
            </template>
        </nav>

        <!-- Guest -->
        <div v-if='!$page.props.auth'>
            <Link
                prefetch
                @click="resetTopic"
                v-text="'Login'"
                :href="route('login.create')"
                class='transition-colors w-24 duration-300 rounded-xl px-4 py-2.5 hover:bg-gray-700 cursor-pointer'
            />
            <Link
                v-text="'Sign Up'"
                @click="resetTopic"
                :href="route('signup.create')"
                class='transition-colors  duration-300 rounded-xl px-4 py-2.5 hover:bg-gray-700 cursor-pointer'
            />
        </div>

        <!-- Authenticated -->
        <pop-up v-else>
            <template #trigger>
                <img
                    alt="image"
                    class="w-14 h-14 rounded-full"
                    :src=" $page.props.auth.user.avatar"
                />
            </template>
            <template #content>
                <Link
                    @click="resetTopic"
                    v-text="'Profile'"
                    :href="route('profile.edit')"
                    class="px-10 py-2 rounded-xl hover:bg-gray-300"
                />
                <Link
                    method="delete"
                    v-text="'Logout'"
                    :href="route('login.destroy')"
                    class="px-10 py-2 rounded-xl hover:bg-gray-300"
                />
            </template>
        </pop-up>
    </header>
</template>
