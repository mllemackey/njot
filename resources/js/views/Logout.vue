<template>
    <div>

    </div>
</template>

<script>
export default {
    name: "Logout",
    created() {
        axios.get('/logout', {})
        .finally(err => {
            // window.location = '/login';
        })
    }
}
</script>

<style scoped>

</style>
