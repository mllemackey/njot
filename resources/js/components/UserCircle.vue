<template>
    <div class="rounded-full border border-gray-400 text-white bg-blue-400 w-10 h-10 flex justify-center items-center">
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
