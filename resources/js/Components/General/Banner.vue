<script setup>
    import { usePage } from '@inertiajs/vue3'
    import Danger from './SVGs/Danger.vue'
    import Success from './SVGs/Success.vue'

    let timeout = ref(null)
    let show = ref(false)
    let style = ref(null)
    let message = ref('')
    let page = usePage()
    let Delay = 3000

    watchEffect(() => {
        style.value = page.props.flash?.styleBanner
        message.value = page.props.flash?.banner
        show.value = true

        clearTimeout(timeout)
        timeout = setTimeout(() => show.value = false, Delay)
    })
</script>

<template>
    <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-300"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-4"
    >
        <div v-if="show && message" @click="show = false" :class='{
         "fixed py-2 px-5 min-h-12 rounded-xl right-7 top-7 flex items-center gap-x-5 z-40 cursor-pointer text-gray-700": true,
         "bg-green-400": style === "success",
         "bg-red-500": style === "danger",
    }'>
            <success v-if="style === 'success'"/>
            <danger v-if="style === 'danger'"/>
            <span class="text-center">{{ message }}</span>
        </div>
    </Transition>
</template>
