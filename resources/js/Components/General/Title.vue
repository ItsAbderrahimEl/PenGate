<script setup>
    import logo from '@img/logo.png'
    import { route } from 'ziggy-js'
    import { usePage } from '@inertiajs/vue3'

    //Hooks
    defineProps({
        subtitle: {
            type: String,
            default: ''
        }
    })

    //Variables
    let page = usePage()
</script>

<template>
    <Link :href="route('posts.index')" prefetch>
        <div class="flex items-start">
            <img class="w-20 h-20" :src="logo" alt="Logo"/>
            <div class="flex flex-col">
                <h1 class="text-5xl font-montserrat text-white font-extrabold"> {{ page.props.app.name }} </h1>
                <h2 class="text-white font-montserrat font-bold text-xl self-end"> {{ subtitle }} </h2>
            </div>
        </div>
    </Link>
</template>
