<template>
    <div :class="checkClass">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-info mt-2">
                    <div class="inner">
                        <h3>1</h3>
                        <p class="font-weight-bolder">Main Menu</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <router-link to="/main_menu" class="small-box-footer">
                        Define Main Menu <i class="fas fa-arrow-circle-right"></i>
                    </router-link>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-success mt-2">
                    <div class="inner">
                        <h3>2</h3>
                        <p class="font-weight-bolder">Sub Menu</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-bars"></i>
                    </div>
                    <router-link to="/sub_menu" class="small-box-footer">
                        Define Sub Menu..<i class="fas fa-arrow-circle-right"></i>
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
                name: "MenuCardsComponent",
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
