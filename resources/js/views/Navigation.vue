<template>
    <div class="pl-6 w-48 h-screen border-r-2 border-gray-400">
        <nav class="pt-4">
            <router-link to="/">
                <img src="/uploads/svg/logo.svg" alt="logo">
            </router-link>

            <p class="pt-12 text-gray-500 text-xs uppercase font-bold">Create</p>

            <router-link to="/events/create" class="flex items-center py-2 hover:text-blue-600 text-sm">
                <img src="/uploads/svg/add.svg" alt="add">
                <div class="tracking-wide pl-3">Add New</div>
            </router-link>

            <p class="pt-12 text-gray-500 text-xs uppercase font-bold">General</p>

            <router-link to="/events" class="flex items-center py-2 hover:text-blue-600 text-sm">
                <img src="/uploads/svg/cake.svg" alt="event" />
                <div class="tracking-wide pl-3">My Events</div>
            </router-link>

            <router-link to="/calendar" class="flex items-center py-2 hover:text-blue-600 text-sm">
                <img src="/uploads/svg/calendar.svg" alt="calendar" />
                <div class="tracking-wide pl-3">Calendar</div>
            </router-link>

            <p class="pt-12 text-gray-500 text-xs uppercase font-bold">Settings</p>

            <router-link to="/logout" class="flex items-center py-2 hover:text-blue-600 text-sm">
                <img src="/uploads/svg/exit.svg" alt="exit" />
                <div class="tracking-wide pl-3">Logout</div>
            </router-link>
        </nav>
    </div>
</template>

<script>
export default {
name: "Navigation"
}
</script>

<style scoped>

</style>
