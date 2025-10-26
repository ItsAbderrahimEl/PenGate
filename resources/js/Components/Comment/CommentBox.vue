<script setup>
    import { onMounted } from 'vue'
    import ErrorInput from '../Form/ErrorInput.vue'
    import TipTapEditor from '../General/TipTapEditor.vue'
    import { useCommentStore } from '../../Stores/Comment.js'

    //Variables
    let editor = ref(null)
    let store = useCommentStore()

    //Hooks
    onMounted(() => {
        store.editor = editor.value
    })
</script>

<template>
    <form
        v-if="$page.props.auth?.user"
        class="flex flex-col gap-y-4"
        @submit.prevent="store.is_updating ? store.update() : store.store()"
    >
        <div>
            <TipTapEditor
                ref="editor"
                v-model="store.form.body"
                example="Comment"
                count-style="text-gray-100"
                class="placeholder-slate-500 bg-gray-100"
                placeholder="Join the conversation—your voice matters!"
            />
            <ErrorInput :error="store.form.errors.body"/>
        </div>

        <div class="self-end space-x-4">
            <button
                :disabled="store.form.processing"
                v-text="store.is_updating ? 'Update' : 'Post'"
                class="secondary-button bg-gray-700 w-32 hover:bg-gray-800 text-white"
            />

            <button
                v-if="store.is_updating"
                v-text="'Cancel'"
                @click.prevent="store.cancelUpdate"
                class="secondary-button bg-red-500 hover:bg-red-600 text-white"
            />
        </div>
    </form>
</template>
