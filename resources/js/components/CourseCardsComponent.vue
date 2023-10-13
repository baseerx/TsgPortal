<template>
<div :class="checkClass">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info mt-2">
                <div class="inner">
                    <h3>1</h3>
                    <p class="font-weight-bolder">Training Type</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book-medical"></i>
                </div>
                <router-link to="/course_type" class="small-box-footer">
                    Define Training Type <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success mt-2">
                <div class="inner">
                    <h3>2</h3>
                    <p class="font-weight-bolder">Training Area</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <router-link to="/course_area" class="small-box-footer">
                    Define Area Of Trainings<i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-gray-light mt-2">
                <div class="inner">
                    <h3>3</h3>
                    <p class="font-weight-bolder">Add Training</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <router-link to="/add_courses" class="small-box-footer">
                    Add Training<i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-light mt-2">
                <div class="inner">
                    <h3>4</h3>
                    <p class="font-weight-bolder">Training Schedule</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book-medical"></i>
                </div>
                <router-link to="/coursesch" class="small-box-footer">
                    Define Training Schedule <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {

        data()
        {
            return {
                name: "TrainingCardsComponent",
                checkClass:'container d-none'
            }
        },
        mounted()
        {
            axios.get('api/uservals/card_check')
                .then(response=>{
                    if (response.data===1)
                    {
                        this.checkClass='container d-block';
                    }
                    else
                    {
                        this.checkClass='container d-none';
                    }
                })
                .catch(error=>console.log(error));
        },
    }
</script>

<style scoped>

</style>
