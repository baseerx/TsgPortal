<template>
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info mt-2">
                <div class="inner">
                    <h3>1</h3>
                    <p class="font-weight-bolder">Create</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <router-link to="/leasingcomps" class="small-box-footer">
                    More info.. <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LeasingCardsComponent"
    }
</script>

<style scoped>

</style>
