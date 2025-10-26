<script setup>
    import { router, usePage } from '@inertiajs/vue3'
    import { require_authentication } from '../../Helpers.js'

    //Variables
    let show = ref(false)
    let page = usePage()

    //Hooks
    let props = defineProps({
        title: String,
        width: String,
        needs_auth: {
            type: Boolean,
            required: false,
            default: false
        }
    })
    onMounted(() => {
        router.on('finish', handleInertiaFinish)
    })

    //Functions
    let handleInertiaFinish = () => {
        if (!Object.keys(page.props.errors || {}).length) {
            closeModal()
        }
    }
    let toggleModal = () => {
        if (require_authentication()) {
            return
        }
        show.value = !show.value
    }

    let closeModal = () => show.value = false
</script>

<template>
    <!-- The trigger -->
    <div class="cursor-pointer" @click="toggleModal">
        <slot name="trigger"/>
    </div>

    <Teleport to="body">
        <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <!-- The backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center"
                 v-show="show"
                 @click="closeModal"
            >
                <div class="max-h-[40rem] rounded-xl overflow-scroll scroll-hidden" @click.stop>
                    <header class="bg-gray-600 px-5 py-3 w-full flex justify-between items-center">
                        <p class="font-semibold text-xl text-gray-200">
                            {{ title }}
                        </p>
                        <div class="cursor-pointer text-4xl text-gray-200" @click="closeModal">
                            &times;
                        </div>
                    </header>

                    <!-- The Content -->
                    <div :class="` bg-gray-900 p-5 ${width}`">
                        <slot name="content"/>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
