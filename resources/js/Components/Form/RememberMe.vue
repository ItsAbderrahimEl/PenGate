<script setup>
    defineProps({
        modelValue: Boolean,
        name: String
    })
    const emit = defineEmits(['update:modelValue'])

    let updateValue = (newValue) => emit('update:modelValue', newValue)
</script>

<template>
    <label class="flex items-center gap-2.5 text-white cursor-pointer w-fit">
        <input
            :name="name"
            type="checkbox"
            class="peer hidden"
            :checked="modelValue"
            @change="updateValue($event.target.checked)"
        />
        <div class="h-5 w-5 flex rounded-md border border-[#a2a1a833] dark:bg-gray-900 peer-checked:bg-[#7152f3] transition duration-200">
            <svg
                class="w-5 h-5 light:stroke-[#e8e8e8] dark:stroke-gray-900"
                fill="none"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M4 12.6111L8.92308 17.5L20 6.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                ></path>
            </svg>
        </div>
        <slot/>
    </label>

</template>
