<template>
    <div class="sidebar-main w-full md:w-56 md:fixed md:h-full bg-white z-20">
        <nav>
            <div class="flex flex-row justify-between md:justify-center items-center px-6 bg-blue-700">
                <router-link to="/" class="app-logo flex justify-start md:justify-center items-center ">
                    <img src="/uploads/svg/logo.svg" alt="logo">
                </router-link>
                <div class="block md:hidden">
                    <button type="button" id="nav-toggle"
                            class="flex items-center px-3 py-2 border rounded text-white border-white hover:text-white hover:border-white"
                    @click="menuHidden = !menuHidden">
                        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                    </button>
                </div>
            </div>

            <div :class="{ hidden: menuHidden }"
                class="sidebar-menu md:block px-6 pt-6 pb-12" id="nav-content"
                 @click="menuHidden = !menuHidden"
            >

                <p class="pt-6 text-gray-500 text-xs uppercase font-bold">Create</p>

                <router-link to="/events/create" class="flex items-center py-2 hover:text-blue-600 text-base">
                    <font-awesome-icon :icon="['fas', 'plus']" class="text-blue-600" />
                    <div class="pl-3">Add New</div>
                </router-link>

                <p class="pt-12 text-gray-500 text-xs uppercase font-bold">General</p>

                <router-link to="/events" class="flex items-center py-2 hover:text-blue-600 text-base">
                    <font-awesome-icon :icon="['fas', 'birthday-cake']" class="text-blue-600" />
                    <div class="pl-3">My Events</div>
                </router-link>

                <router-link to="/administrated-events" class="flex items-center py-2 hover:text-blue-600 text-base">
                    <font-awesome-icon :icon="['fas', 'birthday-cake']" class="text-blue-600" />
                    <div class="pl-3">Administrated Events</div>
                </router-link>

                <router-link to="/calendar" class="flex items-center py-2 hover:text-blue-600 text-base">
                    <font-awesome-icon :icon="['fas', 'calendar-alt']" class="text-blue-600" />
                    <div class="pl-3">Calendar</div>
                </router-link>

                <p class="pt-12 text-gray-500 text-xs uppercase font-bold">Settings</p>

                <router-link to="/logout-manual" class="flex items-center py-2 hover:text-blue-600 text-base">
                    <font-awesome-icon :icon="['fas', 'sign-out-alt']" class="text-blue-600" />
                    <div class="pl-3">Logout</div>
                </router-link>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    name: "Navigation",
    data: function () {
        return {
            menuHidden: true
        }
    }
}
</script>

<style scoped>

</style>
