<script setup>
    import CommentBox from './CommentBox.vue'
    import CommentShows from './CommentShow.vue'
    import Pagination from '../General/Pagination.vue'

    defineProps({ comments: Object })
</script>

<template>
    <div class="space-y-10 my-10 w-2/3 flex flex-col m-auto text-black">
        <comment-box/>

        <comment-shows :comments="comments"/>

        <pagination
            class="self-end"
            :only="['comments']"
            :meta="comments.meta"
            :links="comments.links"/>
    </div>
</template>