import { ref } from 'vue'
import { route } from 'ziggy-js'
import { defineStore } from 'pinia'
import { usePostStore } from './Post.js'
import { useForm } from '@inertiajs/vue3'
import { useConfirm } from '../Composables/useConfirm.js'

//To use this store you need to initialize the editor first (tiptapEditor)
export const useCommentStore = defineStore('CommentStore', () => {

  let editor = ref(null)
  let post_store = usePostStore()
  let is_updating = ref(false)
  let form = useForm({ body: '' })
  let { confirmation } = useConfirm()
  let the_updating_comment_id = ref(null)

  function updateState (comment) {
    editor.value.focus()
    form.body = comment.body
    is_updating.value = true
    the_updating_comment_id.value = comment.id
  }

  function resetFormAndEditor () {
    form.reset()
    editor.value.reset()
  }

  function resetUpdateState () {
    is_updating.value = false
    the_updating_comment_id.value = null
  }

  function cancelUpdate () {
    resetUpdateState()
    resetFormAndEditor()
  }

  async function update () {
    if (await confirmation('Are you sure you want to update', 'Confirm update')) {
      form.put(route('comments.update', the_updating_comment_id.value), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => {
          resetUpdateState()
          resetFormAndEditor()
        }
      })
    }
  }

  async function destroy (comment_id) {
    if (await confirmation('Are you sure you want to delete this comment?', 'Confirm Deletion')) {
      useForm({}).delete(route('comments.destroy', comment_id), {
        preserveScroll: true
      })
    }
  }

  function store () {
    form.post(route('posts.comments.store', post_store.post.id), {
      preserveScroll: true,
      onSuccess: () => {
        resetFormAndEditor()
      }
    })
  }

  return {
    //Data
    is_updating, form, the_updating_comment_id, editor,

    //Actions
    updateState, cancelUpdate, destroy, store, update
  }
})