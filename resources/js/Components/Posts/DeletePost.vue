<script setup>
    import Delete from '../General/SVGs/Delete.vue'
    import { usePostStore } from '../../Stores/Post.js'

    let store = usePostStore()
</script>

<template>
    <button
        @click="store.destroy()"
        v-if="store.post.can.delete && $page.props.auth"
        class="secondary-button bg-red-600 hover:bg-red-700 text-white m-2"
    >
        <delete/>
    </button>
</template>