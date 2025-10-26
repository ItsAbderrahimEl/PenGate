<script setup>
    defineProps({
        title: String,
        description: String
    })
</script>

<template>
    <div class="flex flex-col md:flex-row justify-between  gap-y-10 gap-x-5 sm:px-10 py-7 sm:mx-10 rounded-xl">
        <div class="flex text-center md:text-left w-full gap-y-5 md:w-1/2 flex-col">
            <h1 class=" font-bold text-4xl ">
                {{ title }}
            </h1>
            <p>
                {{ description }}
            </p>
        </div>
        <div class="bg-gray-300 md:w-1/2 rounded-lg shadow-lg text-black">
            <slot/>
        </div>
    </div>
</template>
