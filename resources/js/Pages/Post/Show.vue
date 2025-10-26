<script setup>
    import { usePostStore } from '../../Stores/Post.js'
    import CommentsSection from '../../Components/Comment/CommentsSection.vue'
    import { goBack } from '../../Helpers.js'
    import ArrowBack from '../../Components/General/SVGs/ArrowBack.vue'
    import LikeLikable from '../../Components/General/LikeLikable.vue'
    import DeletePost from '../../Components/Posts/DeletePost.vue'
    //Hooks
    let props = defineProps({
        post: Object,
        comments: Object
    })

    //Variables
    //Used in comment
    usePostStore().post = props.post
</script>

<template>
    <Head title="ShowPost"/>

    <div class="m-5">
        <div class="ml-4">
            <div>
                <button class="mb-5 cursor-pointer" title="Go Back" @click="goBack">
                    <arrow-back class="hover:text-gray-400"/>
                </button>
                <h1 class="font-bold text-4xl text-gray-100">
                    {{ post.title }}
                </h1>
            </div>

            <div class="my-5 py-1 px-3 rounded-md w-fit shadow shadow-gray-400 bg-gray-700">
                {{ post.topic.name }}
            </div>

            <div class="mt-2 text-sm text-gray-400">
                {{ post.created_at }} by {{ post.user.name }}
            </div>

            <div class="flex items-center mt-10">
                <LikeLikable title="Like the Post" likeable_type="post" :likeable="post"/>
                <delete-post title="Delete the Post"/>
                </div>
        </div>

        <article
            class="w-2/3 font-sans mt-10 p-5 markdown-post"
            v-html="post.body"
        />
    </div>

    <div>
        <h1 class="font-bold ml-5 text-3xl text-gray-300 mt-10">
            Comments
        </h1>

        <comments-section :comments/>
    </div>
</template>
