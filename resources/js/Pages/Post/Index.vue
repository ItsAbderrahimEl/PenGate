<script setup>
    import { extractObjects } from '../../Helpers.js'
    import CreatePost from '../../Components/Posts/CreatePost.vue'
    import IndexPosts from '../../Components/Posts/IndexPosts.vue'
    import IndexTopics from '../../Components/Topics/IndexTopics.vue'
    import { useSearchStore } from '../../Stores/search.js'
    import SearchPostByTitle from '../../Components/Posts/SearchPostByTitle.vue'

    //Hooks
    let props = defineProps({
        topics: Object,
        posts: Object
    })

    //Variables
    useSearchStore()
    let topics_copy = extractObjects(props.topics)
</script>

<template>
    <div class="m-5">
        <div class="flex items-center justify-center">
            <search-post-by-title />
        </div>

        <div class="flex justify-between p-10">
            <div class="mt-5 left-5">
                <create-post :topics="topics_copy"/>
                <index-topics :topics="topics_copy"/>
            </div>

            <index-posts :posts/>

            <div></div>
        </div>
    </div>
</template>
