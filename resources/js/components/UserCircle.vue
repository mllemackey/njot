<template>
    <div class="user-circle rounded-full border border-blue-600 text-white md:text-blue-500 text-xs bg-blue-700 md:bg-white w-8 h-8 flex justify-center items-center hover:bg-blue-200 ">
        {{ userCircle }}
    </div>
</template>

<script>
export default {
    name: "UserCircle",
    props: [
        'name'
    ],
    computed: {
        userCircle(){
            let names = this.name.split(' '),
                initials = names[0].substring(0, 1).toUpperCase();

            if (names.length > 1) {
                initials += names[names.length - 1].substring(0, 1).toUpperCase();
            }

            return initials;
        }
    }

}
</script>

<style scoped>

</style>
