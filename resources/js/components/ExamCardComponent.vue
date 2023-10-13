<template>
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>1</h3>

                    <p>Plan Exam</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <router-link to="/exam" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>2</h3>

                    <p>Make Paper</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <router-link class="small-box-footer" to="/paper">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>3</h3>
                    <p>Conduct Exam</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <router-link class="small-box-footer" to="/result">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ExamCardComponent"
    }
</script>

<style scoped>

</style>
