<script setup>
    import computer from '@img/computer.png'
    import tablet from '@img/tablet.png'
    import phone from '@img/phone.png'

    defineProps({
        session: Object
    })
</script>

<template>
    <div class="flex flex-col items-center justify-center">
        <div>
            <img :src="session.device.desktop ? computer
                    : (session.device.tablet ? tablet
                    : (session.device.mobile ? phone : ''))"
                 alt="Session device"
                 class="w-16 h-16"/>
        </div>
        <div class=" flex flex-col items-center justify-between border-gray-500 rounded-md mt-1 text-md">
            <div class="flex gap-x-1">
                <span class="font-semibold text-blue-900"> {{ session.device.platform }} </span>
                <span class="text-green-600"> {{ session.is_current_device ? 'current' : '' }} </span>
            </div>
            <div class="flex gap-x-1">
                <span> {{ session.ip_address }} </span>
                <span class="text-orange-700"> {{ session.device.browser }} </span>
            </div>
            <span> {{ session.last_active }} </span>
        </div>
    </div>
</template>
