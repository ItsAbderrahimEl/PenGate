<script setup>
    import { useCommentStore } from '../../Stores/Comment.js'
    import Delete from '../General/SVGs/Delete.vue'
    import Update from '../General/SVGs/Update.vue'
    import LikeLikable from '../General/LikeLikable.vue'

    //Variables
    let store = useCommentStore()

    //Hooks
    defineProps({
        comments: Object
    })
</script>

<template>
    <div
        :key="comment.id"
        v-for="comment in comments.data"
        class="px-2 py-2 flex bg-gray-50 shadow rounded-md"
    >
        <img
            alt="Avatar"
            :src="comment.user.avatar"
            class="size-20 rounded-full"
        />

        <div class="w-full p-1 justify-start items-start">
            <div class="markdown-comment  text-wrap break-all" v-html="comment.body"/>
            <p class="self-end text-sm mt-10 text-gray-600 block">
                By {{ comment.user.name }} {{ comment.created_at }}
            </p>
        </div>

        <div class="flex flex-col w-fit justify-between items-center mr-2">

            <div>
                <button
                    v-if="comment.can?.delete"
                    title="Delete The Comment"
                    @click="store.destroy(comment.id)"
                    class="cursor-pointer text-gray-500 transition-all  duration-150 hover:scale-110"
                >
                    <Delete version="2" class="size-6 fill-red-500"/>
                </button>
            </div>

            <div>
                <button
                    v-if="comment.can?.update"
                    title="Update The Comment"
                    @click="store.updateState(comment)"
                    class="size-5 cursor-pointer text-gray-500 transition-all duration-150 hover:scale-110"
                >
                    <Update class="size-6"/>
                </button>
            </div>

            <like-likable likeable_type="comment" :likeable="comment"/>
        </div>
    </div>
</template>