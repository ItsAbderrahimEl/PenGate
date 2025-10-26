<script setup>
    import { useConfirm } from '../../Composables/useConfirm.js'

    let { state, confirm, cancel } = useConfirm()
    let ConfirmButtonRef = ref(null)

    let focusConfirmButton = () => ConfirmButtonRef.value.focus()
</script>

<template>
    <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-300"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-4"
        @after-enter="focusConfirmButton"
    >
        <div
            class="fixed inset-0 bg-black bg-opacity-10 flex items-top justify-center"
            v-show="state.show"
            @click="cancel"
        >
            <div
                class="w-2/5 h-48 bg-white flex flex-col justify-between rounded-xl mt-10 overflow-hidden"
                @click.stop
            >
                <div class="flex items-start justify-top  gap-x-10 p-5">
                    <div class="size-16 rounded-xl bg-red-200 shadow shadow-red-200 flex items-center justify-center">
                        <svg class="size-10 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                        </svg>
                    </div>

                    <div class="space-y-4">
                        <p class="font-bold text-gray-800 text-xl">{{ state.title }}</p>
                        <p class="text-gray-500">{{ state.message }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-x-5 p-3 bg-gray-100">
                    <button
                        ref="ConfirmButtonRef"
                        @click="confirm"
                        class="secondary-button focus:ring-2 ring-blue-400 text-white bg-gray-600 shadow hover:bg-gray-700"
                    >
                        Confirm
                    </button>
                    <button
                        class="secondary-button bg-white shadow text-red-600 hover:bg-gray-50"
                        @click="cancel"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>
