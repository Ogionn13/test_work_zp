<template>
    <div class="container mt-3 w-75 d-flex justify-content-center">
        <div class="col-4">
            <div v-if="$parent.result.result && $parent.result.result ==='error'">
                <p  class="card border-3 text-center align-top bg-danger-subtle">{{ $parent.result.message }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "error_block",
}
</script>

<style scoped>

</style>
