<script setup>
    import { route } from 'ziggy-js'
    import { Link } from '@inertiajs/vue3'

    //Hooks
    defineProps({
        post: Object,
        showUser: {
            type: Boolean,
            default: true
        }
    })
</script>

<template>
    <Link
        @click.stop
        :href="route('posts.show', [post.id, post.slug])"
        class="w-full bg-gray-800 block group border border-white/30 shadow-md shadow-white/10 rounded-lg py-5 px-7"
    >
        <div class="flex items-center justify-between">
            <span class="transition-colors font-bold duration-200 group-hover:text-indigo-300">
                {{ post.title }}
            </span>
            <span>
                {{ post.topic.name }}
            </span>
        </div>

        <div class="flex justify-between">
            <Link
                v-if="showUser"
                :href="route('users.show', [post?.user.id, post?.user.name_normalized])"
            >
                <div
                    class="text-sm underline underline-offset-2 text-gray-500 mt-2 hover:text-gray-300 transition-colors duration-300">
                    By {{ post.user.name }}
                </div>
            </Link>
            <div v-else/>
            <div class="text-sm text-gray-500 mt-2">
                Posted {{ post.created_at }}
            </div>
        </div>
    </Link>
</template>