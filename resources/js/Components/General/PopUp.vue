<script setup xmlns="http://www.w3.org/1999/html">
    onMounted(() => document.addEventListener('click', handleClickOutside))

    onBeforeUnmount(() => document.removeEventListener('click', handleClickOutside))

    let show = ref(false)
    let click = (event) => {
        event.stopPropagation()
        show.value = !show.value
    }
    let handleClickOutside = () => {
        if (show.value) {
            show.value = false
        }
    }
</script>

<template>
    <div class="cursor-pointer relative"
         @click="click"
    >
        <slot name="trigger"/>

        <Transition>
            <div class="absolute right-0 "
                 v-show="show"
            >
                <div class="text-gray-900 py-2.5 px-4 bg-gray-200 rounded-xl space-y-1 shadow-lg">
                    <slot name="content"/>
                </div>
            </div>
        </Transition>
    </div>
</template>
