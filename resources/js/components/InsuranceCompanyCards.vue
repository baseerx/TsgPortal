<template>
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info mt-2">
                <div class="inner">
                    <h3>1</h3>
                    <p class="font-weight-bolder">Add</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <router-link to="/insurancecomp" class="small-box-footer">
                    More Info.. <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success mt-2">
                <div class="inner">
                    <h3>2</h3>
                    <p class="font-weight-bolder">Calender</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bars"></i>
                </div>
                <router-link to="/calender" class="small-box-footer">
                    More Info..<i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "InsuranceCompanyCards"
    }
</script>

<style scoped>

</style>
