<template>
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info mt-2">
                <div class="inner">
                    <h3>1</h3>
                    <p class="font-weight-bolder">Asset Type</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <router-link to="/asset_cat" class="small-box-footer">
                    Define Asset Type <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success mt-2">
                <div class="inner">
                    <h3>2</h3>
                    <p class="font-weight-bolder">Asset Category</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bars"></i>
                </div>
                <router-link to="/sub_menu" class="small-box-footer">
                    Define Asset Category..<i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-default mt-2">
                <div class="inner">
                    <h3>3</h3>
                    <p class="font-weight-bolder">Asset Classification</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bars"></i>
                </div>
                <router-link to="/assetcls" class="small-box-footer">
                    Define Asset Classification..<i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AssetsCardsComponent"
    }
</script>

<style scoped>

</style>
