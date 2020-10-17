<template>
    <div class="sidebar-main w-56 bg-white fixed h-full z-50">
        <nav>
            <router-link to="/" class="app-logo flex flex-row justify-center items-center px-6 bg-blue-700">
                <img src="/uploads/svg/logo.svg" alt="logo">
            </router-link>

            <div class="sidebar-menu px-6">

                <p class="pt-12 text-gray-500 text-xs uppercase font-bold">Create</p>

                <router-link to="/events/create" class="flex items-center py-2 hover:text-blue-600 text-sm">
                    <font-awesome-icon :icon="['fas', 'plus']" class="text-blue-600 text-base" />
                    <div class="tracking-wide pl-3">Add New</div>
                </router-link>

                <p class="pt-12 text-gray-500 text-xs uppercase font-bold">General</p>

                <router-link to="/events" class="flex items-center py-2 hover:text-blue-600 text-sm">
                    <font-awesome-icon :icon="['fas', 'birthday-cake']" class="text-blue-600 text-base" />
                    <div class="tracking-wide pl-3">My Events</div>
                </router-link>

                <router-link to="/calendar" class="flex items-center py-2 hover:text-blue-600 text-sm">
                    <font-awesome-icon :icon="['fas', 'calendar-alt']" class="text-blue-600 text-base" />
                    <div class="tracking-wide pl-3">Calendar</div>
                </router-link>

                <p class="pt-12 text-gray-500 text-xs uppercase font-bold">Settings</p>

                <router-link to="/logout" class="flex items-center py-2 hover:text-blue-600 text-sm">
                    <font-awesome-icon :icon="['fas', 'sign-out-alt']" class="text-blue-600 text-base" />
                    <div class="tracking-wide pl-3">Logout</div>
                </router-link>
            </div>
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
